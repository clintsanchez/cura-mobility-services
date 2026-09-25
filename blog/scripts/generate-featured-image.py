#!/usr/bin/env python3
"""Generate a Cura Mobility Services blog featured image (1080x608 WebP, 16:9).

Renders templates/featured-images/blog-featured-template.html through Chrome
headless, then converts the PNG to WebP via Pillow.

1080x608 matches the rest of the BlakSheep pipeline and the publisher's
social_fb_img_width / social_fb_img_height defaults. Do not "upgrade" it to
1200x630 without also changing those, or the SEOPress social payload will
declare dimensions the file does not have.

Usage:

    python3 ./scripts/generate-featured-image.py \\
        --output posts/featured-images/<slug>.webp \\
        --category "Caregiver guides" \\
        --title "Planning the <span class='highlight'>ride home</span> from the hospital" \\
        --sub-deck "What to ask before discharge day and how to get a parent home safely." \\
        --image-url "file:///.../wp-content/uploads/2026/09/<photo>.webp" \\
        --upload-to-wp

Brand notes: Cura Navy base, light-teal highlight, navy-on-tint category tag.
Use Cura's own media-library photos (local file:// paths are fine for the render).
No van-lift or ramp photos: wheelchair vehicle equipment is unconfirmed.
"""

from __future__ import annotations

import argparse
import base64
import json
import re
import subprocess
import sys
import tempfile
import urllib.request
from pathlib import Path

PROJECT_ROOT = Path(__file__).resolve().parent.parent
DEFAULT_TEMPLATE = PROJECT_ROOT / "templates" / "featured-images" / "blog-featured-template.html"
CHROME_PATH = "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"

WIDTH = 1080
HEIGHT = 608

# Brand base colour. Used as the flatten target for any alpha in the render, so
# a transparent edge never composites to white on a dark card.
FLATTEN_RGB = (0x02, 0x26, 0x5A)

DEFAULTS = {
    "SERVICE_LOC": "Baton Rouge and nearby communities",
    "SITE_URL": "Call (225) 363-0845",  # domain unconfirmed; phone instead
    "IMAGE_ALT": "Cura Mobility Services photo",
    "LOGO_URL": "file://" + str(PROJECT_ROOT.parent / "brand" / "assets" / "no-book" / "svg" / "cura-logo-horizontal-on-navy.svg"),
}


def html_escape(value: str) -> str:
    return (
        value.replace("&", "&amp;")
             .replace("<", "&lt;")
             .replace(">", "&gt;")
    )


def render_template(template_path: Path, replacements: dict, raw_fields: set) -> str:
    html = template_path.read_text()
    for key, value in replacements.items():
        token = f"{{{{{key}}}}}"
        if key in raw_fields:
            html = html.replace(token, value)
        else:
            html = html.replace(token, html_escape(value))
    html = re.sub(r"\{\{[A-Z_]+\}\}", "", html)
    return html


def render_html_to_png(html: str, output_png: Path) -> None:
    with tempfile.NamedTemporaryFile(suffix=".html", delete=False, mode="w", encoding="utf-8") as f:
        f.write(html)
        tmp_html = Path(f.name)
    # --- BSC image QC gate (added 2026-08-22). Measures this graphic before Chrome
    # screenshots it, so clipped/overlapping text is caught instead of shipped.
    # Env: BSC_IMAGE_QC=warn (default) | strict | off. See _blaksheep-conventions §0.9.
    try:
        import sys as _sys
        _sys.path.insert(0, "/Users/clintsanchez/Documents/Claude/BlakSheep Creative Content Generation Engine/blaksheep-creative-content-generation-engine/_blaksheep-conventions/scripts")  # this repo lives outside the engine
        from image_qc import gate as _qc_gate
        _qc_gate(tmp_html, WIDTH, HEIGHT, label=output_png.name)
    except ImportError:
        pass
    try:
        cmd = [
            CHROME_PATH,
            "--headless=new",
            "--disable-gpu",
            "--hide-scrollbars",
            "--no-sandbox",
            "--default-background-color=00000000",
            # Remote webfonts + the WP-hosted photo and SVG logo all need to land
            # before capture. 3s was occasionally too tight for a cold font cache.
            "--virtual-time-budget=5000",
            f"--window-size={WIDTH},{HEIGHT}",
            f"--screenshot={output_png}",
            f"file://{tmp_html}",
        ]
        result = subprocess.run(cmd, capture_output=True, text=True, timeout=90)
        if result.returncode != 0 and not output_png.exists():
            print(result.stderr, file=sys.stderr)
            raise RuntimeError(f"Chrome headless render failed (exit {result.returncode})")
    finally:
        tmp_html.unlink(missing_ok=True)


def png_to_webp(png_path: Path, webp_path: Path, quality: int = 88) -> int:
    from PIL import Image
    img = Image.open(png_path)
    if img.size != (WIDTH, HEIGHT):
        img = img.resize((WIDTH, HEIGHT), Image.LANCZOS)
    if img.mode in ("RGBA", "LA"):
        bg = Image.new("RGB", img.size, FLATTEN_RGB)
        bg.paste(img, mask=img.split()[-1])
        img = bg
    elif img.mode != "RGB":
        img = img.convert("RGB")
    webp_path.parent.mkdir(parents=True, exist_ok=True)
    img.save(webp_path, "WEBP", quality=quality, method=6)
    return webp_path.stat().st_size


def upload_to_wp(webp_path: Path, filename_stem: str) -> dict:
    candidates = [
        PROJECT_ROOT / "wp-publish.json",
        Path.home() / ".config" / "wp-publish-cura-mobility-services.json",
    ]
    cfg_path = next((p for p in candidates if p.exists()), candidates[0])
    cfg = json.loads(cfg_path.read_text())
    base = cfg["site_url"].rstrip("/")
    auth = base64.b64encode(
        f'{cfg["username"]}:{cfg["app_password"]}'.encode()
    ).decode()

    filename = filename_stem if filename_stem.endswith(".webp") else f"{filename_stem}.webp"
    data = webp_path.read_bytes()
    req = urllib.request.Request(
        f"{base}/wp-json/wp/v2/media",
        data=data,
        method="POST",
        headers={
            "Authorization": f"Basic {auth}",
            "Content-Type": "image/webp",
            "Content-Disposition": f'attachment; filename="{filename}"',
            # WP Engine sits behind Cloudflare. A browser UA avoids the 1010
            # challenge on authenticated media POSTs.
            "User-Agent": (
                "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) "
                "AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36"
            ),
        },
    )
    with urllib.request.urlopen(req, timeout=120) as resp:
        return json.loads(resp.read())


def article_title_plain(html_title: str) -> str:
    return re.sub(r"<[^>]+>", "", html_title).strip()


def main() -> None:
    ap = argparse.ArgumentParser(
        description="Generate a Cura Mobility Services blog featured image (1080x608 WebP)"
    )
    ap.add_argument("--output", type=Path, required=True, help="Output WebP path")
    ap.add_argument("--category", required=True,
                    help="Category-tag eyebrow text (e.g. 'Caregiver guides')")
    ap.add_argument("--title", required=True,
                    help="Article title. Raw HTML allowed: <br> for breaks, "
                         "<span class='highlight'>X</span> for a gold-accented phrase. "
                         "Use ONE highlight at most; gold is used with restraint.")
    ap.add_argument("--sub-deck", required=True,
                    help="Sub-deck explainer (1 sentence, ~20-35 words max)")
    ap.add_argument("--service-loc", default=DEFAULTS["SERVICE_LOC"],
                    help="Service-area line")
    ap.add_argument("--site-url", default=DEFAULTS["SITE_URL"],
                    help="Brand signature URL line")
    ap.add_argument("--image-url", required=True,
                    help="Photo URL for the image panel. Use a Cura media-library photo.")
    ap.add_argument("--image-alt", default=DEFAULTS["IMAGE_ALT"],
                    help="Alt text for the image panel")
    ap.add_argument("--logo-url", default=DEFAULTS["LOGO_URL"],
                    help="Footer logo URL (default: white horizontal lockup)")
    ap.add_argument("--template", type=Path, default=DEFAULT_TEMPLATE,
                    help="Override template path")
    ap.add_argument("--quality", type=int, default=88,
                    help="WebP quality (0-100, default 88)")
    ap.add_argument("--upload-to-wp", action="store_true",
                    help="Upload result to WP media library")
    ap.add_argument("--wp-filename", default="",
                    help="Override upload filename stem (default: derived from --output)")
    ap.add_argument("--keep-png", action="store_true",
                    help="Don't delete the intermediate PNG")
    args = ap.parse_args()

    if not args.template.exists():
        sys.exit(f"Template not found: {args.template}")
    if not Path(CHROME_PATH).exists():
        sys.exit(f"Chrome not found at {CHROME_PATH}")

    replacements = {
        "CATEGORY_TAG": args.category,
        "ARTICLE_TITLE_HTML": args.title,
        "ARTICLE_TITLE_PLAIN": article_title_plain(args.title),
        "SUB_DECK": args.sub_deck,
        "SERVICE_LOC": args.service_loc,
        "SITE_URL": args.site_url,
        "IMAGE_URL": args.image_url,
        "IMAGE_ALT": args.image_alt,
        "LOGO_URL": args.logo_url,
    }
    raw_fields = {"ARTICLE_TITLE_HTML", "IMAGE_URL", "LOGO_URL"}

    html = render_template(args.template, replacements, raw_fields)

    png_tmp = args.output.with_suffix(".png")
    print("Rendering HTML → PNG via Chrome headless ...", file=sys.stderr)
    render_html_to_png(html, png_tmp)

    print(f"Converting PNG → WebP (quality={args.quality}) ...", file=sys.stderr)
    size = png_to_webp(png_tmp, args.output, quality=args.quality)
    if not args.keep_png:
        png_tmp.unlink(missing_ok=True)

    print(f"✓ Generated: {args.output}  ({size/1024:.1f} KB)")

    if args.upload_to_wp:
        filename_stem = args.wp_filename or args.output.stem
        print("Uploading to WordPress media library ...", file=sys.stderr)
        media = upload_to_wp(args.output, filename_stem)
        print(f"✓ WP media id={media['id']}")
        print(f"  URL: {media['source_url']}")


if __name__ == "__main__":
    main()
