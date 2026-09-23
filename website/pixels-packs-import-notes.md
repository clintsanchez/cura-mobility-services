# Pixels Library Plus: import notes for Cura

*2026-09-23. Source: `~/Downloads/Pixels-Library-Plus.zip` (831 MB, 2,452 files). The two packs we use are extracted to pCloud `Clients/Cura Mobility Services/02-Website-Content/pixels-packs/`.*

## What the zip's documentation says
- **Top level:** `ReadDocumentationBeforeStart.txt` points to https://pixelslibraryplus.com/docs/how-to-use-pixels-library-plus/. There are two import routes: (1) the **Remote Access URL** (a password-protected demo site added as a Breakdance Design Library source) or (2) **XML import**.
- **`Breakdance Layouts Pack/Remote Access URL.txt` / `COPY ALL URL.txt`:** Design Library URLs with passwords for every pack. Ours:
  - #1 Cab Services: `bdlayoutspack.com/breakdance-cab-services-layouts-pack`
  - #194 Senior Care (v2): `bdtemplatehub.com/breakdance-senior-care-layouts-pack` (#32 is the older v1; don't use it)
- **Senior Care v2 has two extra instruction folders:**
  1. **Import Global JSON:** `senior-care-global-settings.json` (settings only), imported via **Breakdance → Settings → Global Styles → Launch Breakdance → Globals → ⋯ → Import Global Settings**.
  2. **Add Custom Code:** paste the **Font Awesome 7.0.1** stylesheet `<link>` (cdnjs) into **Breakdance → Settings → Custom Code → Footer Code**. The pack's icons need it.
- **Cab Services** has no extra instructions.
- **`Plugins/`** holds optional Pixels add-on elements: Cursor, Essentials, Events Calendar, Flipcard, Projects. **Not needed; don't install** (turnkey: fewest plugins).
- **`license.txt`** lists the image sources used in the demos. The demo images are **not** ours to publish; replace them all with our licensed photos.

## What the files actually contain (inspected)
| File | Contents |
|---|---|
| `cabservices/cabservices-layoutspack.xml` | 18 pages (Home, About Us, Services, Services List/Single, Get A Cab, Taxi Rates, FAQs, Contact Us, Testimonial, Team Member, portfolio/blog variants, Refund policy), 1 header, 1 footer, 11 Breakdance templates, 5 taxi blog posts, 22 menu items, 39 image attachments (**hotlinked from `woocommercecore.mystagingwebsite.com`**), 2 wp_templates, and **9 form-submission records containing real people's email addresses** |
| `senior-care-2/senior-care.xml` | 27 pages (Home, About Us, Services + 6 service pages, Care Plans, FAQs, Contact Us, Testimonials, Schedule a Tour, Team, Careers, Style Guide, blog variants), 1 header, 1 footer, 18 templates (duplicated "Fallback" set), 1 popup, 10 senior-care blog posts, 31 menu items, 26 attachments, 2 wp_global_styles |
| `*/cabservices.json`, `senior-care-2/senior-care.json` | **Full Breakdance options exports from the author's site, including the author's license key, design-library password and revisions.** |
| `senior-care-2/Import Global JSON/senior-care-global-settings.json` | Global settings only (`{settings:{…}}`). This one is safe. |

## Rules for our import (non-negotiable)
1. **Never import the full `cabservices.json` / `senior-care.json` options exports.** They would overwrite Cura's valid Breakdance Pro license with the author's and clobber settings. Use only the global-settings payload.
2. **Never import `breakdance_form_res` records.** They hold third parties' personal emails.
3. **Skip the demo blog posts, portfolio pages, WooCommerce and fallback templates, and `wp_template` / `wp_global_styles`.** Import a filtered XML.
4. **Only one header and footer set.** Use Cab Services' (booking CTA), restyle it, and don't import Senior Care's.
5. **Cab Services is the base:** its pages, header, footer and templates, plus its global settings mapped to Cura (see `breakdance-global-settings.md`). **Senior Care v2: pages only**, with its colors re-pointed to the Cura palette after import.
6. Localize or replace every image. No hotlinks to `mystagingwebsite.com` / `bdlayoutspack.com` / `bdtemplatehub.com`.
7. **Back up the database before importing.**
8. Keep the Font Awesome footer link only if the pages we keep use FA icons. Otherwise prefer Breakdance's built-in icons (fewer external requests).

## Import log (2026-09-23)
- Blueprint placeholder pages 1204–1220 **trashed** (recoverable). No DB backup was taken; Clint said to skip it.
- **Cab Services** imported from a filtered XML (`wp-content/uploads/cura-import/cab-filtered.xml`), with no attachments, posts, form submissions, menus or WooCommerce:
  - Pages: Home 67 (**set as front page**), About Us 180, Services 182, Contact Us 186, Team Member 200, Testimonial 202, FAQs 204, Get A Cab 206, Taxi Rates 208, Services List 210, Services Single 212.
  - Header 176 and Footer 244 (both "everywhere"). Templates: Single Post 369, 404 392, Search Results 396 (disabled), Post Archive 454.
- **Senior Care v2**, pages only, imported as **drafts prefixed "SC –"** to copy sections from: Home 125, About 126, Services 37, Care Plans 1256, Testimonials 1255, Assisted Living 1254, Schedule a Tour 1253, Services Grid 1257, Rehabilitation 1258, Respite 51, Skilled Nursing 53, FAQs 127, Contact 65.
- **Global settings** written in Breakdance's own format (`{"settings":{…}}` via `Breakdance\Data\save_global_settings`). ⚠️ Novamira's `breakdance-edit-global-settings` saved them without the `settings` wrapper, so Breakdance ignored them. Use the native save function.
  - Cab palette slots re-valued to Cura, plus `cura-teal` and `cura-tint`.
  - **Senior Care's `--bdp-*` variables added**, mapped: primary→#047878, secondary→#02265A, light→#E6F4F4, border→navy 10%, light-text→#FFF.
  - Fonts: `gfont-montserrat` for headings and `gfont-atkinsonhyperlegible` for body (Breakdance font IDs strip spaces).
  - H1/H2/H3 scale per the style guide. Primary button: navy, Teal Deep on hover, 10px radius, 17px/600.
- Font Awesome CDN **not added**. No page uses FA classes; Breakdance icons are inline SVG.
- **Still demo content:** taxi imagery, lorem ipsum, "Since 1992" stats, taxi rates, Pixels logos in the header, footer and logo strip, a "Get Lifetime Access" promo badge, and a New York address and phone in the top bar.
