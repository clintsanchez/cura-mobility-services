# Cura Mobility Services — Work-in-Progress Handoff

*Last updated: 2026-09-22 (scaffolded from GHL). Read this first when resuming.*

## Status: freshly onboarded from the BSC Onboarding Survey
Michael Veal (Cura Mobility Services). Brief + brand docs populated from real survey data.

## Access / facts
- **Contact:** Michael Veal · +12253630845 · mveal72@yahoo.com · _not provided_
- **Facebook:** _not captured_
- **GHL contact (source of truth):** `8OcXVaFmoaaMc5LfpNy6`
- **Platform today:** Not Sure
- **Hosting / domain logins:** see `CREDENTIALS.local.md` (gitignored) → move to a
  password manager and delete from disk.

## What they told us (verbatim)
- **Business:** _not captured_
- **Differentiator:** _not captured_
- **Priority service:** _not captured_ · **Pricing:** _not captured_
- **90-day goal:** Leads, traffic
- **Challenge:** This!! Lol
- **Brand colors (described):** primary _not captured_, secondary _not captured_, accent _not captured_
- **Voice:** Professional, Empathetic / Warm, Friendly / Approachable
- **Do NOT mention:** _not captured_

## 2026-09-22 onboarding findings
- **Business:** NEMT (van). NPI 1730096504 verified; LLC formed 2026-08-20 (charter 47164816K, via Bizapedia).
- **Palette:** navy `#02265A`, logo teal `#058D8D` (graphics only), text-safe teal `#047878`. Sampled from JPG; confirm from vector.
- **CSS prefix:** `cura-`. See `CONTENT-ENGINE-CONTRACT.md`.
- **Research:** `06-Reports/research-2026-09-22.md` (domain, licensing path, competitors, keywords).
- **Client asks:** `CLIENT-ASKS.md`, **sent 2026-09-22**, awaiting answers. Everything downstream waits on #1 to #3.
- **Guardrails:** no "licensed", no "Medicaid provider", no tenure, no address, no "statewide" until confirmed.
- Survey had no business-name field; the name came from the uploaded logo.

## Brand package (2026-09-22)
- `brand/` package: `brand.yaml`, `context.md`, `voice.md`. `brand-style-guide.md` is rewritten (guidelines, contrast-checked palette, type, logo rules). `DESIGN.md` and `css-tokens.css` are synced.
- **Logo set (2026-09-23):** `brand/assets/svg/` holds 10 SVGs (stacked, horizontal, mark, square and wordmark, each with an on-navy version; the swoosh has a real gradient). `brand/assets/png/` holds favicons, the site icon, avatars and transparent logos. All are web-grade; print still needs the originals or a redraw. A **no-book version** of the full set is in `brand/assets/no-book/` (R and A redrawn), pending ask #9.
- **Messaging:** `brand/messaging.md`. Recommended tagline: "Cura means care." (cura is Latin for care), pending Michael.
- **Breakdance design kit:** `website/breakdance-global-settings.md` maps the Cab Service pack's 6 palette slots, fonts and buttons to Cura, plus the CTA standard and the pack clean-up checklist.

## Site build (2026-09-23)
- Local site `https://cura-mobility.local` (LocalWP), Novamira MCP `novamira-cura-mobility-lo` (local scope). Site identity, favicon and America/Chicago are set.
- Pixels **Cab Services** pages, header, footer and templates imported; the Cab Home is the front page. **Senior Care v2** pages imported as `SC –` drafts. The Cura global settings (palette, fonts, buttons) are applied. Details and IDs: `website/pixels-packs-import-notes.md`. Next: replace the demo content, logos, images and copy page by page.

## Photo library (2026-09-23)
- In pCloud `05-Photos/`: 170 stock originals (107 Envato Elements + 63 Unsplash) with `stock/manifest.csv`, plus **159 SEO-named WebP web files** in `web/<page>/` with `web/image-map.csv` (alt text, use, license). See `05-Photos/README.md`. Register the Envato items to the Cura project before publishing. Gaps: real photos of Michael, his van and drivers; dialysis-specific scenes; side-ramp minivan.

## Scope decision (2026-09-22)
- **Turnkey WordPress-only site.** No monthly maintenance and no GHL: forms, booking and review requests must work natively in WordPress. **Builder: Breakdance** (decided 2026-09-23; this replaces the brief Elementor decision). The Pixels Library Plus packs sit closest to Michael's inspiration sites (a photo hero with an overlapping ride-booking form), and it's the leanest stack: Breakdance Pro plus free SEOPress, with forms, header and footer built in. The templates are the **Cab Service Layouts Pack** (booking hero and structure) and the **Senior Care Layouts Pack v2** (warm care sections). See `06-Reports/template-kit-shortlist-2026-09-23.md`. Open: whether Cura stays on Clint's Breakdance license after handoff (lifetime?) or Michael buys his own. Strip the kits' invented stats and replace hotlinked demo images before launch. The monthly content-engine/blog-CTA fulfilment doesn't apply after launch unless the scope changes.

## 2026-09-22 SEO research (free sources; SE Ranking out of credits)
- **Report:** `seo/keyword-research.md` (keyword map, live map-pack snapshot, Google Business Profile plan). Raw agent output is in `seo/research-2026-09-22/`.
- No local provider ranks organically. The map-pack leaders are Hammond (4.5/33), **Mitresonz (5.0/185)** and Tender Kare (3.3/74). Nearly all competitors use the generic "Transportation service" category.
- No search volumes yet. Backfill from Keyword Planner, or from SE Ranking once credits are topped up.
- **Services proxy:** Michael texted (2026-09-22) that his model matches his consultant's company **Mitresonz** (mitresonz.net), minus the luxury services. Use Mitresonz's service list as the working assumption until he answers ask #2. He also sent 3 more inspiration sites; see `00-Client-Brief.md` §7.
- Verida/Southeastrans phone numbers conflict between sources. Verify on LDH before publishing any.

## 🚨 Before publishing ANY public claim
Run `06-Reports/records-check.md`. Verify license, years in business
(Less than 1 year), and registered address vs. service area against
authoritative sources. Do not print unverified credentials.

## Next steps (when resuming)
1. ~~Sample brand hex~~ done 2026-09-22 (raster; confirm from vector).
2. ~~Public-records check~~ first pass done; confirm SoS record by hand.
3. Stitch design system: optional now (building in Breakdance; design kit in `website/breakdance-global-settings.md`).
4. ~~SEO research~~ first pass done 2026-09-22 (`seo/keyword-research.md`). Next: sitemap + homepage brief; service and city pages wait on client asks #2, #4, #6 and #7.

## Open confirmations
- [ ] Brand hex confirmed from vector (raster re-sample matches) · fonts proposed: Montserrat + Atkinson Hyperlegible (client to approve)
- [ ] Logo: web-grade traced set in `brand/assets/svg` + `png`. Print/van graphics still need vector originals (ask #11) or a redraw
- [ ] Pricing display (public vs. quote/subscription)
- [ ] Tagline (recommend "Cura means care."; options in `brand/messaging.md`)
- [ ] Service-area page priority (grow-in: _not captured_)
- [ ] Move credentials to password manager, delete `CREDENTIALS.local.md`

## Trello board
- **Cura Mobility Services:** https://trello.com/b/5kLuwsCB/cura-mobility-services

## Repo
- GitHub: https://github.com/clintsanchez/cura-mobility-services (private)
