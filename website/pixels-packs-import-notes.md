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

## Build log: header, footer, homepage (2026-09-23)
- **Helper:** `wp-content/novamira-sandbox/cura-bd.php` (`cura_bd_load/set/get/remove/save`, `cura_upload`, `cura_bd_image`). `cura_bd_save` rewrites `_breakdance_data` and regenerates the page CSS via `Breakdance\Render\generateCacheForPost()`. Note: `function_exists()` needs the namespace **without** a leading backslash.
- **Header 176:** Cura horizontal logo; "Primary" WP menu (id 35: Home, About, Services, Rates, FAQs, Contact) assigned via `content.menu.menu`; top bar set to (225) 363-0845 (tel), info@curamobility.org ⏳ (domain unconfirmed), "Serving the Baton Rouge area"; social icons removed (no accounts); button → "Book a ride" → /book-a-ride/.
- **Pages renamed:** Get A Cab 206 → **Book a Ride** `/book-a-ride/`; Taxi Rates 208 → **Rates** `/rates/`.
- **Footer 244:** CTA "Book your next ride" + phone button; on-navy logo; description with the 911 line; link grid; contact column; "Stay in touch" sign-up; dynamic © year with "Cura Mobility Services. All rights reserved."; social icons and the **"GET LIFETIME ACCESS" Pixels promo button removed**.
- **Home 67:** every section kept in order, content swapped:
  - The hero label color was changed to #E6F4F4 (navy was unreadable on the photo).
  - The ride-request form now emails **clint@blaksheepcreative.com** (it was the pack author's Gmail). ⏳ Switch to Michael at handoff.
  - Payment-brand icons removed (accepted methods unconfirmed).
  - Progress-bar percentages removed.
  - Rates tables became "ride types" with no prices.
  - Client-logo wall (194) and reviews (415) set to `settings.advanced.draft` (hidden) until real ones exist.
  - Service icons: Font Awesome 6 Free solid (stethoscope, wheelchair, hospital) as inline SVG.
  - Default "Hello world!" post trashed.
- **Global CSS (`settings.code.stylesheets`):**
  - "Cura: accessibility": hides `.bde-skip-link` until focused, plus focus rings. It was visible because the child theme lacks Breakdance's base skip-link rule.
  - Senior Care "layout classes" (`.px_container`, `.px_footer_link`, `.px_page_title_breadcrums`), needed by SC sections.
  - Senior Care "image and icon transitions", **with its `.button-atom--primary:after` Font Awesome arrow removed**: it needs the FA CDN, and it rendered as an empty box on every Cab button.
- **Copy flags for Michael (⏳):** the owner quote "Cura is Latin for care. It is how we drive, every ride." (attributed to Michael Veal, Owner); "call when we are on the way" and "recurring rides" promises; info@curamobility.org.

## Build log: inner pages (2026-09-23)
- **About 180, Services 182, Contact 186, FAQs 204, Book a Ride 206, Rates 208:** pack structure kept section for section; content, images and links swapped for Cura's.
  - **Contact:** the address box is now "Service area" (no street address); socials removed. The form emails clint@blaksheepcreative.com ⏳. The map is a key-free Google embed of Baton Rouge; it replaced the pack's "Crazy Cars, NJ" iframe, which carried an API key.
  - **FAQs:** 9 plain-language Q&As covering what NEMT is, booking, notice, mobility aids, pricing, Medicare and Medicaid, ride-alongs and service area. There is no provider claim; the answers point people to their own plan. The request form is copied from home; the team section is hidden.
  - **Book a Ride:** a phone strip, the ride-request form, 4 "Who we help" image cards (no prices), ride options and a CTA.
  - **Rates:** "How pricing works" uses the no-price ride-options tables; the team section is hidden.
- **Breakdance FAQ element:** reads `content.settings.items[{question,answer}]`, not `questions`.
- **Helper bug fixed:** `cura_bd_copy_into` looped over `($dst['children'] ?? [])`, a temporary copy, so earlier section copies only changed the top node. All copies have been re-run. A scan of every built page for lorem, taxi, cab, pack-domain hotlinks, $ prices, "Lifetime" and the demo names now comes back clean.
- **URL conflict fixed:** the BSC Meta Box post types **Services** (mb-post-type 31) and **FAQs** (19) had `has_archive: true`, so `/services/` and `/faqs/` served empty CPT archives instead of the pages. Archives are now off and rewrite rules are flushed. Keep these CPTs: they are the data source for the planned loop/card phase, with singles at `/services/<slug>/`.
- **Contrast fix:** eyebrow labels on the navy and slate bands (home 342/245, services 135, about 145/219, book 152, rates 136) are now Tint #E6F4F4; they were palette navy.

## Build log: service pages (2026-09-23)
- **9 service pages** built from the Services Single (212) structure as top-level pages at the slugs Services 182 already links to:

  | Page | ID | Slug |
  |---|---|---|
  | Doctor and specialist visits | 1304 | `/doctor-appointment-rides/` |
  | Dialysis rides | 1307 | `/dialysis-transportation/` |
  | Wheelchair transportation | 1310 | `/wheelchair-transportation/` |
  | Hospital discharge rides | 1314 | `/hospital-discharge-rides/` |
  | Treatment and therapy rides | 1318 | `/treatment-and-therapy-rides/` |
  | Senior and everyday rides | 1322 | `/senior-and-everyday-rides/` |
  | Prescription pickups | 1326 | `/prescription-pickup-and-delivery/` |
  | Long-distance medical trips | 1328 | `/long-distance-medical-transportation/` |
  | Recurring ride schedules | 1331 | `/recurring-rides/` |

  - Top-level rather than `/services/<slug>/`, so they never collide with the `services` CPT rewrite.
  - Copy, photos, bullets and FAQs are in `website/content/service-pages.php` (the same file the build reads from the sandbox).
- **Sidebar:** 9 service links, the "Send a message" form (emails clint@blaksheepcreative.com ⏳), Download box hidden.
- **Main column:** banner, photo, intro, photo plus 5-point checklist, 3 FAQs; the team grid is hidden.
- **Drafted:** Services Single 212 (renamed "Services Single (template)"), Services List 210 (it would duplicate /services/), Team Member 200 and Testimonial 202 (no real team or reviews yet).
- **Templates cleaned:**
  - 369, 392, 396 and 454 now use the Baton Rouge skyline banner.
  - 404 copy rewritten.
  - The Single Post demo gallery and social icons are hidden; the related posts are relabeled "More articles".
  - A rendered-HTML crawl of all 16 public pages, plus a 404 and a search URL, finds no pack domains, lorem, taxi or "Lifetime" text.
  - Hidden (draft) elements still hold pack image URLs in `_breakdance_data`; strip them before launch.
- **Dynamic phase later:** move the 9 pages into the `services` CPT with a Breakdance single template and Meta Box fields (intro, bullets, FAQs, images), then swap the Services grid, the sidebar and the Book a Ride cards to loops.
