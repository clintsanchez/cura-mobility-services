# WordPress REST toolkit — Tiger Town Construction

A small, reusable client + CLI over the site's WP REST API. Loads credentials from
the repo `.env` (gitignored), handles the LocalWP self-signed cert, Application-Password
auth, **Meta Box** fields (the `meta_box` key), and **SEOPress** meta.

- `wp_client.py` — the `WP` client class (import it from build scripts).
- `wp.py` — the CLI (subcommands below).
- `breakdance-api-notes.md` — what Breakdance exposes to developers, and the key
  finding: **page layouts are NOT REST-writable** (build designs in the Breakdance UI;
  push data/media/SEO via this toolkit).

## Setup
1. Fill in `.env` (see `.env.example`): `WP_SITE_URL`, `WP_USER`, `WP_APP_PASSWORD`.
2. `python3 -m pip install --user requests`
3. Test: `python3 tools/wp/wp.py ping`

## CLI

```
python3 tools/wp/wp.py <command> [...]

ping                          Test auth; print who you are.
info                          Site name/description + plugin namespaces.
types                         Post types + REST base + item counts.
count <rest_base>             Count items (services, locations, media, ...).
list <rest_base> [-n N]       List items (id, slug, title).
get <rest_base> <id|slug>     Full JSON of one item (edit context).
terms <taxonomy>              List terms (e.g. service-categories).
create-term <tax> <name> [--slug s] [--desc d]
upsert <rest_base> <slug>     Create/update a post by slug:
    --title --status (default draft) --excerpt --content
    --meta key=value          Meta Box field (repeatable, goes under meta_box)
    --seo-title --seo-desc --seo-kw
upload <file>                 Upload ONE file to the Media Library:
    --alt --title --caption
```

### Examples
```bash
python3 tools/wp/wp.py ping
python3 tools/wp/wp.py types
python3 tools/wp/wp.py create-term service-categories "Outdoor Living" --slug outdoor-living
python3 tools/wp/wp.py upsert services patio-covers \
    --title "Patio Covers" --status draft \
    --meta svc_tagline="Custom-built to fit your home" \
    --seo-title "Patio Covers | Tiger Town Construction" \
    --seo-desc "Custom patio covers in the Baton Rouge area."
```

### From Python
```python
import sys; sys.path.insert(0, "tools/wp")
from wp_client import WP
wp = WP()
wp.whoami()
wp.upsert("services", "screen-rooms", {"title": "Screen Rooms", "status": "draft"})
wp.upload_media("tools/photos/delivery/patio-covers/xyz.webp", alt="Custom patio cover ...")
wp.set_seopress(123, title="...", desc="...")
```

## What works (verified against the local site)
- ✅ Auth (Application Password, self-signed cert via `verify=False`).
- ✅ Read: site info, post types, counts, list, get, terms.
- ✅ Write: taxonomy terms; CPT create/update by slug (`upsert`).
- ✅ Meta Box fields: the `services` CPT exposes `meta_box` over REST — fields write **once the
  field group is imported** (our defs: `website/wp-build/service-details.mb-fields.json`).
  *(Currently the groups aren't imported on this site yet — importing them is a build step.)*
- ✅ SEOPress: title + description via `PUT seopress/v1/posts/{id}/title-description-metas`.
  (Target-keyword route param shape varies by build; the client tries it but won't fail the call.)
- ✅ Media upload (single) with title/alt/caption. **Bulk photo upload is intentionally a separate,
  deliberate step — not wired into a one-shot here.**

## Stack on this site (from REST namespaces)
Breakdance · Meta Box AIO · SEOPress · WS Form · WP Grid Builder · Smush.
CPTs: `services`, `locations`, `team`, `review`, `faqs`, `products`, `forms`, `policies`.

## Gotchas
- **LocalWP self-signed cert** → all calls use `verify=False` (client handles it).
- **Meta Box fields live under `meta_box`**, not the standard `meta` key. Field group must be
  imported AND `show_in_rest:true`.
- **SEOPress title/desc route is PUT**, not POST, and is `.../title-description-metas`.
- **Breakdance page layouts can't be written via REST** — see `breakdance-api-notes.md`.
- Drafts are excluded from the default `list`/count public query; use `get`/edit context to see them.
