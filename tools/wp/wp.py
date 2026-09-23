#!/usr/bin/env python3
"""Tiger Town Construction — WordPress REST CLI.

A small toolkit over the WP REST API (Breakdance + Meta Box + SEOPress + WS Form +
WP Grid Builder stack on LocalWP). Loads creds from .env automatically.

COMMANDS
  ping                       Test auth; print who you are.
  info                       Site name/description/URL + plugin namespaces.
  types                      List post types + their REST base + item counts.
  count <rest_base>          Count items in a CPT (e.g. services, locations, media).
  list <rest_base> [-n N]    List items (id, slug, title) in a CPT.
  get <rest_base> <id|slug>  Fetch one item (full JSON, edit context).
  terms <taxonomy>           List terms (e.g. service-categories).
  create-term <tax> <name> [--slug s] [--desc d]
  upsert <rest_base> <slug>  Create/update a post. --title, --status, --excerpt,
                             --content, --meta k=v (repeatable, -> meta_box),
                             --seo-title, --seo-desc, --seo-kw.
  upload <file>              Upload ONE file to the Media Library. --alt --title --caption.
                             (Bulk photo upload is a separate, deliberate step — not here.)

EXAMPLES
  python3 tools/wp/wp.py ping
  python3 tools/wp/wp.py types
  python3 tools/wp/wp.py list services -n 20
  python3 tools/wp/wp.py create-term service-categories "Outdoor Living" --slug outdoor-living
  python3 tools/wp/wp.py upsert services patio-covers --title "Patio Covers" --status draft \\
        --meta svc_tagline="Custom-built to fit your home" --seo-title "Patio Covers | Tiger Town"
"""
import argparse
import json
import sys
import pathlib

sys.path.insert(0, str(pathlib.Path(__file__).resolve().parent))
from wp_client import WP


def j(x):
    print(json.dumps(x, indent=2, ensure_ascii=False))


def cmd_ping(wp, a):
    me = wp.whoami()
    print(f"✓ Authenticated as: {me.get('name')} (id {me.get('id')}, roles: {','.join(me.get('roles', []) or [])})")
    print(f"  Site: {wp.site}")


def cmd_info(wp, a):
    info = wp.site_info()
    print(f"Name:        {info.get('name')}")
    print(f"Description: {info.get('description')}")
    print(f"URL:         {info.get('url')}")
    ns = info.get("namespaces", [])
    print(f"Namespaces ({len(ns)}): {', '.join(sorted(ns))}")


def cmd_types(wp, a):
    types = wp.post_types()
    rows = []
    for key, t in types.items():
        rb = t.get("rest_base") or key
        try:
            c = wp.count(rb)
        except Exception:
            c = "?"
        rows.append((key, rb, c))
    w = max(len(r[0]) for r in rows)
    for key, rb, c in sorted(rows):
        print(f"  {key.ljust(w)}  rest_base={rb.ljust(16)} count={c}")


def cmd_count(wp, a):
    print(wp.count(a.rest_base))


def cmd_list(wp, a):
    items = wp.get(f"wp/v2/{a.rest_base}", per_page=a.n, context="edit",
                   orderby="date", order="desc")
    for it in items:
        title = (it.get("title", {}) or {}).get("rendered") or (it.get("title") if isinstance(it.get("title"), str) else "")
        print(f"  {str(it.get('id')).rjust(5)}  {str(it.get('slug','')).ljust(40)}  {title}")
    print(f"({len(items)} shown; total {wp.count(a.rest_base)})")


def cmd_get(wp, a):
    ident = a.ident
    if ident.isdigit():
        j(wp.get(f"wp/v2/{a.rest_base}/{ident}", context="edit"))
    else:
        item = wp.find_by_slug(a.rest_base, ident)
        if not item:
            sys.exit(f"No {a.rest_base} with slug '{ident}'")
        j(item)


def cmd_terms(wp, a):
    terms = wp.get_all(f"wp/v2/{a.taxonomy}", context="edit")
    for t in terms:
        print(f"  {str(t.get('id')).rjust(5)}  {str(t.get('slug','')).ljust(30)}  {t.get('name')}  (count {t.get('count')})")
    print(f"({len(terms)} terms)")


def cmd_create_term(wp, a):
    body = {"name": a.name}
    if a.slug:
        body["slug"] = a.slug
    if a.desc:
        body["description"] = a.desc
    res = wp.post(f"wp/v2/{a.taxonomy}", json=body)
    print(f"✓ term '{res.get('name')}' (id {res.get('id')}, slug {res.get('slug')})")


def cmd_upsert(wp, a):
    payload = {"status": a.status}
    if a.title:
        payload["title"] = a.title
    if a.excerpt:
        payload["excerpt"] = a.excerpt
    if a.content:
        payload["content"] = a.content
    if a.meta:
        mb = {}
        for kv in a.meta:
            if "=" not in kv:
                sys.exit(f"--meta expects key=value, got '{kv}'")
            k, v = kv.split("=", 1)
            mb[k.strip()] = v
        payload["meta_box"] = mb  # Meta Box fields live under meta_box
    res, action = wp.upsert(a.rest_base, a.slug, payload)
    pid = res.get("id")
    print(f"✓ {action} {a.rest_base}/{a.slug} (id {pid})")
    if a.seo_title or a.seo_desc or a.seo_kw:
        try:
            wp.set_seopress(pid, title=a.seo_title, desc=a.seo_desc, keyword=a.seo_kw)
            print("  ✓ SEOPress meta set")
        except Exception as e:
            print(f"  ! SEOPress meta failed: {e}")


def cmd_upload(wp, a):
    m = wp.upload_media(a.file, title=a.title, alt=a.alt, caption=a.caption)
    print(f"✓ uploaded id {m.get('id')}: {m.get('source_url')}")


def build_parser():
    p = argparse.ArgumentParser(description="Tiger Town WordPress REST CLI")
    sub = p.add_subparsers(dest="cmd", required=True)

    sub.add_parser("ping").set_defaults(fn=cmd_ping)
    sub.add_parser("info").set_defaults(fn=cmd_info)
    sub.add_parser("types").set_defaults(fn=cmd_types)

    sp = sub.add_parser("count"); sp.add_argument("rest_base"); sp.set_defaults(fn=cmd_count)

    sp = sub.add_parser("list"); sp.add_argument("rest_base"); sp.add_argument("-n", type=int, default=20)
    sp.set_defaults(fn=cmd_list)

    sp = sub.add_parser("get"); sp.add_argument("rest_base"); sp.add_argument("ident")
    sp.set_defaults(fn=cmd_get)

    sp = sub.add_parser("terms"); sp.add_argument("taxonomy"); sp.set_defaults(fn=cmd_terms)

    sp = sub.add_parser("create-term"); sp.add_argument("taxonomy"); sp.add_argument("name")
    sp.add_argument("--slug"); sp.add_argument("--desc"); sp.set_defaults(fn=cmd_create_term)

    sp = sub.add_parser("upsert"); sp.add_argument("rest_base"); sp.add_argument("slug")
    sp.add_argument("--title"); sp.add_argument("--status", default="draft")
    sp.add_argument("--excerpt"); sp.add_argument("--content")
    sp.add_argument("--meta", action="append", help="key=value (Meta Box field); repeatable")
    sp.add_argument("--seo-title", dest="seo_title"); sp.add_argument("--seo-desc", dest="seo_desc")
    sp.add_argument("--seo-kw", dest="seo_kw"); sp.set_defaults(fn=cmd_upsert)

    sp = sub.add_parser("upload"); sp.add_argument("file")
    sp.add_argument("--alt"); sp.add_argument("--title"); sp.add_argument("--caption")
    sp.set_defaults(fn=cmd_upload)

    return p


def main():
    args = build_parser().parse_args()
    wp = WP()
    args.fn(wp, args)


if __name__ == "__main__":
    main()
