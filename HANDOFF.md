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

## Dynamic build (2026-09-23)
- **Services and FAQs are now data-driven.** 9 Services posts (at `/services/<slug>/`) and 36 FAQs posts in WP admin feed Breakdance loops:
  - the Services grid;
  - the Single Service template, with its sidebar, highlights and related-FAQ loops;
  - the FAQs page accordion.
- Details and IDs: `website/pixels-packs-import-notes.md` → "Dynamic phase". Build scripts: `website/build/`.

## Reviews (2026-09-23): 🚨 SAMPLE placeholders
- The 27 reviews are placeholders with synthetic headshots, not real riders. They're in review category **Sample** and show only on the local site (the visible tag was removed on 2026-09-23; the category guard stays). The live site hides the review sections until real reviews exist.
- **Launch blocker:** delete the Sample reviews, then collect real ones through the GBP review ask. Never present the samples as genuine (CLAUDE.md guardrail, FTC 2024 rule).

## Forms (2026-09-24)
- All forms are WS Form. Each redirects to its own confirmation page (`confirmation` CPT: Hero title + Content fields). **Notifications go to Michael at mveal72@yahoo.com.** ⏳ Live site: set up SMTP and a curamobility.org From address, then send a real test. Map: `website/pixels-packs-import-notes.md` → "Form routing".

## Policies (2026-09-23)
- The five policies are rewritten for Cura Mobility Services, LLC; the blueprint's other-client names and addresses are removed. ⏳ Before launch: Michael/attorney review, set the effective date to launch day, confirm the email domain, and trim the tool mentions to what's actually installed. Details: `website/pixels-packs-import-notes.md` → "Policies rewritten".

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

## Blog: Senior and caregiver guide cluster (published 2026-09-24, backdated weekly)

- **Published (backdated weekly):** hub 1541 `medical-rides-for-aging-parents-baton-rouge`, spokes 1543 `planning-ride-home-hospital-discharge` and 1545 `wheelchair-walker-parent-appointments`. Author 2 (Cura Mobility Services), category 40 Caregiver guides, permalink `/caregiver-guides/<slug>/`.
- **Workspace:** `blog/` (brief, verified stats in `briefs/research-stats.md`, posts, SVGs, featured images, review docs in `blog/reviews/`, inbound plans in `blog/plans/`). Render with `blog/scripts/render_post.py`, push new drafts with `website/build/cura-blog-push.php` (drafts only, idempotent by slug); refresh published content with `cura-blog-update.php`.
- **CSS:** Breakdance global stylesheet "Cura: blog" (copy in `blog/templates/cura-blog.css`); blog CTA standard applied (phone = outlined secondary button, equal-width column buttons).
- **Single Post template 369:** pack Gallery (hotlinked bdlayoutspack.com) and generic Social Share removed. Still pack layout otherwise (search, categories, tag cloud, archives, comments). Decide sidebar + comments before publishing.
- **Before Phase B (publish):**
  - Publish all three together (hub and spokes link to each other).
  - Louisiana Medicaid details are confirmed for one plan only (Louisiana Healthcare Connections); LDH pages blocked automated checks. Verify in a browser.
  - Phase C: apply `blog/plans/*-inbound.json` (service intro links + hub cross-links).

## Resources (blog archive), 2026-09-24

- **Resources page 1547** (`/resources/`) is the posts page (`page_for_posts`), 9 posts per page. SEOPress title/description set.
- **Post Archive template 454** (posts page + category archives): hero H1 and breadcrumb use Archive Title; Posts Loop on the main query with number pagination, 3-column grid like Services.
- **Blocks:** Post card 1549 (Service card clone: featured image, category eyebrow, excerpt, "Read article" pinned to the bottom), Resources empty 1550.
- **WPCodeBox snippet 1 ("Custom PHP")**: appended `cura-archive-title` filters (posts page shows "Resources" instead of "Archives"; no "Category:" prefix). Original code backed up in option `cura_wpcb_snippet1_backup`.
- CSS in "Cura: blog" (copy: `blog/templates/cura-blog.css`). Build script: `website/build/cura-resources.php` (idempotent).
- **Links:** Resources is in the footer Helpful links (Footer 244, second column after FAQs); not in the header menu (Clint's call).
- **Homepage "Helpful guides" section (Home 67 #213):** pack Postslist replaced by the same Posts Loop + Post card (latest 3 published posts, Resources empty state).
- **Open:** card grid verified server-side only until posts are published.

## Blog publish (Phase B + C), 2026-09-24

- **Published, backdated one a week:** 1541 hub (2026-09-10), 1543 discharge (2026-09-17), 1545 wheelchair/walker (2026-09-24), all 9:00 am Central. `/caregiver-guides/<slug>/`.
- Verified in browser: 1 H1, 3 CTAs each (phone outlined secondary, equal 520px buttons), SVG, quick answer, TLDR, Article + FAQPage schema; all 21 internal links 200; Resources grid equal-height cards with aligned buttons.
- **Inbound links (blog/plans):** intro paragraphs added to services 1338 doctor, 1346 wheelchair, 1350 discharge, 1358 senior; hub 1541 now links to both spokes (also in the hub markdown).
- Single Post template 369: all comment elements removed (post-meta comment count, CommentsList, CommentForm). Comments are also off site-wide via WPCodeBox snippet 1. Previous/next post links kept.
- Related links box has a "Related reading" title (styled p.cura-related-title, not a heading), added by blog/scripts/render_post.py.
- **Still open:** Single Post sidebar/"More articles" (pack Postslist) redesign; category archive noindex; Louisiana Medicaid details confirmed on one plan's page only.
- **Blog interlinking (2026-09-24):** every post links to both siblings in the body (distinct anchors) and at the top of its Related reading box. Source of truth is the markdown; re-render with `blog/scripts/render_post.py`, then refresh live content with `website/build/cura-blog-update.php` (content only; keeps dates/status/meta).
- **SEO completion (2026-09-24):** see seo/keyword-research.md §9a. 31 indexed items, 0 gaps; pack demo categories/tags deleted; default category = Caregiver guides.
- **Category archives noindexed (2026-09-24):** SEOPress Titles > Taxonomies > Categories = noindex, and categories removed from the XML sitemap. Posts and /resources/ stay indexed. Reverse both once there is more than one category.

## Service pages as landing pages (2026-09-24)
- **New Service Content fields (group 1337):** `hero_subhead` (text), `who_for` (wysiwyg), `faq_heading` (text), filled for all 9 services (`website/build/cura-service-landing-fields.php`). Copy stays inside existing site claims.
- **Single Service 1387** (`website/build/cura-service-landing-template.php`): hero = H1, breadcrumb, subheading, "Request this ride" (jumps to the sidebar form `#request-ride`) + "Call (225) 363-0845". After the highlights: "Who this ride is for" (field), "How booking a ride works" (3 static steps), "Serving the Baton Rouge area" (static, links to /rates/). FAQ kicker removed; FAQ H2 = `faq_heading` (fallback "Common questions").
- **Mobile/tablet (<1120px):** the sidebar (services list + form) follows the content. CSS: "Cura: service landing" (copy: `website/build/cura-service-landing.css`).
- **Footer CTA (244):** "Request a ride" (white solid) + "Call (225) 363-0845" (outlined) in one row; footer contact phone line also reads "Call (225) 363-0845".
- **Per-service section headings (2026-09-24):** fields `who_heading`, `how_heading`, `area_heading`, `area_text` (group 1337), filled for all 9 (`website/build/cura-service-landing-headings.php`); template H2s use them with the generic text as fallback. The 3 booking steps stay shared.

## Typography note: slashed zero (decided 2026-09-24: keep)
- The body font, Atkinson Hyperlegible (Braille Institute), draws 0 with a diagonal slash on purpose so it can't be confused with the letter O. There is no plain-zero alternate (tested: its OpenType features and Atkinson Hyperlegible Next both keep the slash).
- Clint chose to keep it for legibility. If Michael asks: it's an accessibility feature for low-vision riders. Fallback if he dislikes it: set phone links and buttons in Montserrat, or change the body font (fonts are still an open confirmation).

## WP Engine (review site), 2026-09-24
- **URL:** https://curamobility.wpenginepowered.com (pushed from Local by Clint). Environment type `production`, so the Sample reviews are hidden there automatically.
- **Novamira MCP:** `novamira-curamobility-wpe` (local scope in ~/.claude.json; app password not in the repo). Local site keeps `novamira-cura-mobility-lo`. Changes made after the push were applied to BOTH sites.
- **Search-and-replace:** the push had already updated home/siteurl, options and post content, but missed 44 `_breakdance_data` rows (JSON-escaped URLs). Replaced host `cura-mobility.local` → `curamobility.wpenginepowered.com` (dry run first; JSON validated per row), 0 left; Breakdance caches rebuilt (94 posts); WPE memcached + Varnish purged. Script: `website/build/cura-search-replace.php`. GUIDs left as is.
- **Error log fix:** `mbr.to IN ()` SQL error from Breakdance cache regeneration. Relationship loops (1387 #169, #269; block 1454 #107) now return an empty query when there is no ID (`website/build/cura-relationship-guard.php`).
- **Regression fixed:** re-running the service template script had rewritten the "Cura: service landing" CSS without the inline-button fix; the fix now lives in the script. Hero + footer CTA buttons are inline ≥768px, stacked on phones.
- **Booking links:** every "Book a ride" / "Request a ride" / "Request this ride" button links to /book-a-ride/ (the service hero button no longer jumps to the sidebar form).
- WP Engine's Cloudflare blocks curl (403); check pages with a browser (Playwright) or via the MCP.
