#!/usr/bin/env python3
"""Render a Cura blog post (markdown + frontmatter) to Gutenberg HTML with the
wp-blog-publisher's own renderer, without touching WordPress.

Cura drafts are pushed through the Novamira MCP (no REST app password on disk),
so this script stops at the payload: it writes posts/<slug>.render.json with the
title, slug, excerpt, content HTML and SEO/social meta, plus the FAQ schema
sidecar (posts/<slug>.faq-schema.html). The push step reads that JSON.

    /usr/bin/python3 scripts/render_post.py posts/<slug>.md
"""
from __future__ import annotations

import json
import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
sys.path.insert(0, str(ROOT / "wp-blog-publisher" / "bin"))
import wp_publish as wp  # noqa: E402

PREFIX = "cura-"

# The related-links box gets a title styled as a heading but marked up as a paragraph, so every post
# doesn't carry the same "Related reading" H2 in its outline.
RELATED_TITLE = ('<!-- wp:paragraph {"className":"cura-related-title"} -->\n'
                 '<p class="cura-related-title">Related reading</p>\n'
                 '<!-- /wp:paragraph -->\n')


# The phone number lives in WordPress (Settings > Business info). Posts carry shortcodes, not the number:
# [cura_phone] = linked number, [cura_phone link=no] = plain number, [cura_phone_tel] = digits for tel: hrefs.
PHONE_DISPLAY = "(225) 363-0845"
PHONE_TEL = "+12253630845"


def dynamic_phone(text: str) -> str:
    text = text.replace(f'<a href="tel:{PHONE_TEL}">{PHONE_DISPLAY}</a>', "[cura_phone]")
    text = text.replace(f"tel:{PHONE_TEL}", "tel:[cura_phone_tel]")
    return text.replace(PHONE_DISPLAY, "[cura_phone link=no]")


def add_related_title(html: str) -> str:
    if "cura-related-title" in html:
        return html
    return html.replace('<div class="wp-block-group cura-related">\n',
                        '<div class="wp-block-group cura-related">\n' + RELATED_TITLE, 1)


def main() -> None:
    src = Path(sys.argv[1]).resolve()
    meta, body = wp.parse_frontmatter(src.read_text())
    title = wp.derive_title(meta, body)
    body = wp.strip_leading_h1(body, title)

    # <!-- svg:name | caption --> expands to an inline <figure> from posts/svg/name.svg
    def _svg(m: re.Match) -> str:
        svg = (src.parent / "svg" / f"{m.group(1).strip()}.svg").read_text().strip()
        svg = re.sub(r">\s+<", "><", svg)  # one line, so markdown leaves it alone
        cap = (m.group(2) or "").strip()
        return "<figure class=\"cura-figure\">" + svg + (f"<figcaption>{cap}</figcaption>" if cap else "") + "</figure>"
    body = re.sub(r"<!--\s*svg:([\w-]+)\s*(?:\|\s*(.*?))?\s*-->", _svg, body)

    # The FAQ H2 is topical ("What caregivers ask about ..."), never "FAQ", so point the
    # publisher's extractor at the last H2 whose ### children are all questions.
    lines = body.splitlines()
    h2s = [i for i, l in enumerate(lines) if l.startswith("## ")]
    faq_h2 = None
    for n, i in enumerate(h2s):
        end = h2s[n + 1] if n + 1 < len(h2s) else len(lines)
        qs = [l for l in lines[i:end] if l.startswith("### ")]
        if qs and all(q.rstrip().endswith("?") for q in qs):
            faq_h2 = i
    probe = list(lines)
    if faq_h2 is not None:
        probe[faq_h2] = "## FAQ"
        # Stop the last answer at the next ::: block (related / cta), not only at an H2.
        for j in range(faq_h2 + 1, len(probe)):
            if probe[j].startswith(":::"):
                probe[j] = "## END"
                break
    faqs = wp.extract_faqs("\n".join(probe))
    if faqs:
        src.with_suffix(".faq-schema.html").write_text(dynamic_phone(wp.build_faq_jsonld(faqs)) + "\n")

    body, blocks = wp.process_mda_blocks(body, PREFIX)
    html = wp.markdown_to_html(body)
    for ph, rendered in blocks.items():
        html = html.replace(f"<p>{ph}</p>", rendered).replace(ph, rendered)
    html = wp.wrap_tables_with_mda(html, PREFIX)
    html = add_related_title(html)
    html = dynamic_phone(html)
    html = wp.wrap_gutenberg_blocks(html)

    keys = ["slug", "excerpt", "seo_title", "seo_description", "target_keyword",
            "social_fb_title", "social_fb_desc", "social_twitter_title",
            "social_twitter_desc", "featured_image", "primary_category", "status"]
    out = {"title": title, "content": html, **{k: meta.get(k, "") for k in keys},
           "faq_count": len(faqs)}
    dest = src.with_suffix(".render.json")
    dest.write_text(json.dumps(out, indent=1, ensure_ascii=False))

    # Quick structural report
    ctas = len(re.findall(r'wp-block-group cura-cta', html))
    tel_buttons = len(re.findall(r'wp-block-button__link[^>]*href="tel:', html))
    bare_tel = len(re.findall(r'<p><a href="tel:[^"]*">Call', html))
    print(json.dumps({"file": dest.name, "chars": len(html), "faqs": len(faqs),
                      "cta_blocks": ctas, "tel_buttons": tel_buttons,
                      "bare_tel_paragraphs_in_cta": bare_tel}, indent=1))


if __name__ == "__main__":
    main()
