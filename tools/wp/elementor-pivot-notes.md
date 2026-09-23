# Pivot: Bricks → Elementor (Konstrava kit)

*2026-06-08. The Bricks build was rejected; pivoted to Elementor Pro + a purchased Envato template kit. This file is the source of truth for the new direction until Novamira memory is re-synced (its MCP was bound to the old domain and disconnected on the rename).*

## The site
- **Same LocalWP site, renamed in place.** Former `tiger-town-construction-bricks.local` → now **`https://tiger-town-construction-elementor.local`** (DB siteurl/home already updated; MySQL socket `qgI6TyF2F`; site files still under `~/Local Sites/tiger-town-construction-bricks/`).
- The ORIGINAL Breakdance site (`tiger-town-construction.local`, socket `mVmJz6qOX`) is untouched.

## Bricks — fully purged (done)
- DB: 0 `bricks_template` posts, 0 `%bricks%` postmeta, 0 `bricks_*` options. Header/footer templates (2320/2321), all global classes/variables/color-palette/theme-styles/settings gone.
- Theme switched off Bricks. **Client then installed the Elementor stack** (do NOT touch themes).
- Novamira sandbox files I added (ttc-fonts-and-base.php, ttc-header-scroll.php, ttc-fonts/) — slated for removal; client reinstalled stack so verify/remove if still present.

## Active stack (confirmed via DB)
Hello Elementor (`hello-elementor`) + child `blaksheep-creative-hello-elementor-child 3`. Plugins: **Elementor + Elementor Pro**, **Template Kit Import** (Envato importer), ElementsKit Lite, Metform, Qi Addons, JEG Elementor Kit, Header Footer Elementor, HappyFiles, Meta Box AIO, WS Form PRO, SEOPress(+Pro), Smush, WPCodeBox2, **Novamira + Novamira Pro**.

## The template kit
- **Konstrava — Building Construction** Elementor Template Kit (Envato).
- Zip: `~/Downloads/konstrava-building-construction-elementor-templa-2026-06-08-21-36-00-utc.zip` (unzipped folder beside it).
- Manifest: 14 templates — `global` (kit styles), `header`, `footer`, and pages: home, about-us, service, projects, our-team, pricing, blog, contact-us, contact-us-form, faq, 404.
- Look: dark theme, gold/yellow accent, sharp corners, photo-forward, bold condensed display hero, stats (years/projects), service cards, "why choose us." Good structural fit for Tiger Town; demo content is generic heavy-construction (dump trucks) — will be adapted.

## Plan (agreed with client)
1. **Client imports the kit via the plugin UI** (Elementor → Template Kits → Import → upload the zip → include Templates + Global Settings + Site Parts). Import AS-IS first.
2. Client reviews the raw imported kit.
3. THEN adapt to Tiger Town section by section: real project photos (the 17 uploaded, ids 2322–2338; hero pick patio-cover-evening=2329), guardrail-safe copy (no "50+ years"/license #; "decades of combined experience"; "Serving Denham Springs & Greater Baton Rouge"), brand purple #401F78 / gold #F9C94B via the global kit, WS Form for contact, Meta Box `options` dynamic data for header/footer contact info.

## Access / config
- `.env`: added `WP_SITE_URL_ELEMENTOR` / `WP_API_URL_ELEMENTOR`; legacy `*_BRICKS` vars now alias the same elementor domain. Same admin user + app password.
- `.mcp.json`: Novamira URL updated to the elementor domain. **Restart the Claude Code session to reconnect Novamira MCP** to the new host (the in-session tools were bound to the old URL).
- Novamira memory ids from the Bricks era (2316 build-decisions, 2317 guardrails, 2318 brand-contact, 2319 design-system, 2339 assets, 2340 header/footer) — the design-system/header-footer ones are now STALE (Bricks-specific). Guardrails (2317) and brand-contact (2318) and assets/photos (2339) still valid. Update once reconnected.

## Planned: single-service template (build later, agreed 2026-06-08)
The Konstrava kit has NO single-service template — we'll build one.
- **Approach:** Elementor Theme Builder → Single template, display condition = Singular → `services` CPT, so every service post renders through it.
- **Content model:** DYNAMIC from Meta Box custom fields (client confirmed) — per-service hero image, intro, features, gallery, FAQs pulled via Elementor dynamic tags. Add a service = fill fields, no rebuild.
- **Components:** harvest from the imported kit (esp. `service.json` ~1MB and `projects.json`) so styling matches — hero banner, image+text, feature/icon cards, process steps, gallery, FAQ, related-services, final CTA.
- **Pre-reqs to check after import + reconnect:** (1) which service-detail components `service.json` actually provides; (2) existing Meta Box fields on the `services` CPT vs. what to add (hero image, intro, features repeater, gallery). The `faqs` CPT already has a relationship to services — reuse for the FAQ section.

## Progress log (Elementor build)
**Imported & assembled (done):** Konstrava kit imported (active global kit = post 2348). Library templates: Home 2415, About 2401, Service 2413, Projects 2406, Team 2408, Pricing 2380, Blog 2369, Contact 2385, FAQ 2374, 404 2387, Contact Form 2357, Header 2376, Footer 2383. **Published live pages created from them:** Home 2417 (FRONT PAGE), About 2418, Services 2419, Projects 2420, Team 2421, Pricing 2422, Blog 2423, Contact 2424, FAQ 2425. Header(2376)+Footer(2383) converted to Elementor Pro Theme Builder parts, condition `include/general` (entire site), verified serving.

**Brand recolor (done):** Kit gold #F4B70C → brand gold **#F9C94B** (global custom color id 32b8a51 'Yellow'→'Gold', ~225 refs + 49 hardcoded). Kit pink/red secondary #F2295B → brand **purple #401F78** (~24, hover/highlights — how purple entered). Kit dark amber #9F7500 → brand **gold-deep #E0AE2E** (gradients). Added Purple (id `ttcpurp` #401F78) + Purple Deep (id `ttcpurpd` #2E1556) to kit palette. Near-black base + whites KEPT (client: no purple wash). Pre-brand kit settings backed up in post meta `_ttc_kit_settings_backup_pre_brand` on 2348.

**On-gold contrast rule (done):** text/icons ON gold must be dark **purple #401F78**, NEVER white (client flagged; matches DS "never white on gold"). Fixed gold buttons (jkit_button + core button) + gold-fill `icon` widgets across header + pages. Left alone: gold bullet icons beside white text on dark bg (correct white-on-dark).

**Removed (done):** the diagonal `qi_addons_for_elementor_text_marquee` "QUALITY MATERIALS · PROFESSIONAL" banner — removed site-wide (one section per page, all docs). 0 refs left.

**Color mapping decision:** gold = the action/accent (high contrast on dark); purple = structure/brand presence (premium bands, secondary buttons), introduced selectively — NOT purple primary buttons on dark (low contrast).

**Workflow notes:** client does NOT want screenshots — verify via render/data checks and report. Novamira MCP reconnected automatically to the elementor domain.

**Next (not done):** adapt demo content to Tiger Town (real photos ids 2322–2338, hero 2329; guardrail-safe copy; WS Form on contact; Meta Box {mb_options_*} dynamic data in header/footer). Place purple deliberately (premium band / secondary buttons). Single-service Theme Builder template (dynamic from Meta Box fields). Trash leftover demo pages (Gutter Cleaning, Team Single, old empty Home 125, etc.).

## Still valid regardless of builder
- Accuracy guardrails (no license #, no "50+/6–10 yrs", no street-address-as-fact unless client chose to show the Baton Rouge record, no fabricated reviews, no politics/religion).
- Brand facts, services, service area, contact info (in Meta Box `options` settings page — dynamic tokens `{mb_options_*}`).
- The 17 real project photos in the media library (ids 2322–2338).
