"""Tiger Town Construction — WordPress REST API client.

Thin wrapper around the WP REST API that loads credentials from the repo .env,
handles the LocalWP self-signed cert (verify=False), Application-Password auth,
Meta Box fields (the `meta_box` key), and SEOPress meta.

Used by wp.py (CLI) and any build scripts. Read the .env once; reuse the session.

Env vars (from .env):
  WP_SITE_URL, WP_API_URL, WP_USER, WP_APP_PASSWORD
"""
import os
import pathlib
import sys

try:
    import requests
    from requests.auth import HTTPBasicAuth
except Exception:
    print("The `requests` library is required:  python3 -m pip install --user requests")
    raise

REPO = pathlib.Path(__file__).resolve().parent.parent.parent
ENV = REPO / ".env"


def load_env(path=ENV):
    """Minimal .env loader: KEY=VALUE lines, supports ${VAR} expansion + quotes."""
    vals = {}
    if not path.exists():
        return vals
    for raw in path.read_text().splitlines():
        line = raw.strip()
        if not line or line.startswith("#") or "=" not in line:
            continue
        k, v = line.split("=", 1)
        k = k.strip()
        v = v.strip()
        if (v.startswith('"') and v.endswith('"')) or (v.startswith("'") and v.endswith("'")):
            v = v[1:-1]
        # expand ${VAR} against already-parsed values then os.environ
        while "${" in v:
            start = v.index("${"); end = v.index("}", start)
            name = v[start + 2:end]
            v = v[:start] + (vals.get(name) or os.environ.get(name, "")) + v[end + 1:]
        vals[k] = v
    return vals


class WP:
    def __init__(self, verify=False, timeout=30):
        env = load_env()
        self.site = (env.get("WP_SITE_URL") or "").rstrip("/")
        self.api = (env.get("WP_API_URL") or f"{self.site}/wp-json").rstrip("/")
        self.user = env.get("WP_USER") or ""
        self.pw = env.get("WP_APP_PASSWORD") or ""
        if not (self.site and self.user and self.pw):
            sys.exit("Missing WP_SITE_URL / WP_USER / WP_APP_PASSWORD in .env")
        self.timeout = timeout
        self.s = requests.Session()
        self.s.auth = HTTPBasicAuth(self.user, self.pw)
        self.s.verify = verify  # LocalWP self-signed cert
        if not verify:
            import urllib3
            urllib3.disable_warnings()

    # ---- low-level ----
    def url(self, path):
        if path.startswith("http"):
            return path
        return f"{self.api}/{path.lstrip('/')}"

    def get(self, path, **params):
        r = self.s.get(self.url(path), params=params, timeout=self.timeout)
        r.raise_for_status()
        return r.json()

    def get_raw(self, path, **params):
        return self.s.get(self.url(path), params=params, timeout=self.timeout)

    def post(self, path, json=None, **kw):
        r = self.s.post(self.url(path), json=json, timeout=self.timeout, **kw)
        if not r.ok:
            raise RuntimeError(f"POST {path} -> {r.status_code}: {r.text[:400]}")
        return r.json()

    def put(self, path, json=None, **kw):
        r = self.s.put(self.url(path), json=json, timeout=self.timeout, **kw)
        if not r.ok:
            raise RuntimeError(f"PUT {path} -> {r.status_code}: {r.text[:400]}")
        return r.json()

    # ---- pagination ----
    def get_all(self, path, per_page=100, **params):
        out, page = [], 1
        while True:
            params.update(per_page=per_page, page=page)
            r = self.get_raw(path, **params)
            if r.status_code == 400:  # past last page
                break
            r.raise_for_status()
            batch = r.json()
            if not batch:
                break
            out.extend(batch)
            total_pages = int(r.headers.get("X-WP-TotalPages", "1") or 1)
            if page >= total_pages:
                break
            page += 1
        return out

    def count(self, rest_base):
        r = self.get_raw(f"wp/v2/{rest_base}", per_page=1)
        return int(r.headers.get("X-WP-Total", "0") or 0)

    # ---- helpers ----
    def whoami(self):
        return self.get("wp/v2/users/me")

    def site_info(self):
        return self.get("")

    def post_types(self):
        return self.get("wp/v2/types")

    def find_by_slug(self, rest_base, slug):
        items = self.get(f"wp/v2/{rest_base}", slug=slug, per_page=1, context="edit")
        return items[0] if items else None

    def upsert(self, rest_base, slug, payload):
        """Create or update a post by slug. payload may include meta_box / meta."""
        existing = self.find_by_slug(rest_base, slug)
        body = dict(payload)
        body.setdefault("slug", slug)
        if existing:
            return self.post(f"wp/v2/{rest_base}/{existing['id']}", json=body), "updated"
        return self.post(f"wp/v2/{rest_base}", json=body), "created"

    def upload_media(self, file_path, title=None, alt=None, caption=None):
        """Upload a file to the Media Library; set title/alt/caption."""
        p = pathlib.Path(file_path)
        mime = {
            ".webp": "image/webp", ".jpg": "image/jpeg", ".jpeg": "image/jpeg",
            ".png": "image/png", ".gif": "image/gif", ".svg": "image/svg+xml",
            ".pdf": "application/pdf",
        }.get(p.suffix.lower(), "application/octet-stream")
        headers = {
            "Content-Disposition": f'attachment; filename="{p.name}"',
            "Content-Type": mime,
        }
        r = self.s.post(self.url("wp/v2/media"), headers=headers,
                        data=p.read_bytes(), timeout=max(self.timeout, 120))
        if not r.ok:
            raise RuntimeError(f"upload {p.name} -> {r.status_code}: {r.text[:300]}")
        media = r.json()
        meta = {}
        if title is not None:
            meta["title"] = title
        if alt is not None:
            meta["alt_text"] = alt
        if caption is not None:
            meta["caption"] = caption
        if meta:
            media = self.post(f"wp/v2/media/{media['id']}", json=meta)
        return media

    def set_seopress(self, post_id, title=None, desc=None, keyword=None):
        """Set SEOPress title/description (and optional target keyword) via the
        SEOPress REST routes on this version:
          POST seopress/v1/posts/{id}/title-description-metas  {title, description}
          POST seopress/v1/posts/{id}/target-keywords          {value: [..]}
        """
        results = {}
        if title is not None or desc is not None:
            # GET current so we don't blank the other field
            cur = self.get(f"seopress/v1/posts/{post_id}/title-description-metas")
            body = {
                "title": title if title is not None else cur.get("title", ""),
                "description": desc if desc is not None else cur.get("description", ""),
            }
            results["title_desc"] = self.put(
                f"seopress/v1/posts/{post_id}/title-description-metas", json=body)
        if keyword is not None:
            kws = [k.strip() for k in (keyword.split(",") if isinstance(keyword, str) else keyword) if k.strip()]
            # keyword route param shape varies by SEOPress build; try, but don't
            # let it sink the title/desc write.
            try:
                results["keywords"] = self.put(
                    f"seopress/v1/posts/{post_id}/target-keywords", json={"value": kws})
            except Exception as e:
                results["keywords_error"] = str(e)[:150]
        return results
