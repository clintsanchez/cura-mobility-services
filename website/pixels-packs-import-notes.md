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

## Dynamic phase: loops and cards (2026-09-23)
**Content now lives in posts; Breakdance loops render it. Editors change services and FAQs in WP admin, not in the builder.**

### Data (Meta Box, on the BSC blueprint's post types)
- **Service Content** field group (meta-box post 1337) on `services`:
  - `card_icon`: select from the `cura_icons` option, which holds 13 Font Awesome 6 solid SVGs.
  - `banner_image`, `detail_image`.
  - `highlights`: cloneable group, subfield `text`.
  - The Services type now also supports the editor (intro text). Title, excerpt (card text), featured image and menu order (sort) were already supported.
- **9 Services posts** (1338–1370) at `/services/<slug>/`, sorted by menu order. The static service pages 1304–1331 are **trashed**.
- **36 FAQs posts:**
  - 9 **General**, used on the FAQs page.
  - 27 **Service questions**, each linked to its service via the blueprint relationship `faq_to_service`.
- **Build scripts** (idempotent; run via Novamira `execute-php` with `require`) are in `website/build/`: `cura-data.php`, `cura-template.php` and the `cura-bd.php` helpers. The live copies sit in `wp-content/cura-build/`.
  - ⚠️ **Never put scripts with top-level code in `wp-content/novamira-sandbox/`.** Novamira auto-loads every file there on every request.

### Breakdance
- **Global blocks:**
  - **Service card** (1383): Div > Code Block (icon from `card_icon`) + the pack's IconBox with dynamic title, excerpt and permalink.
  - **Service sidebar link** (1384): the pack's sidebar Button with dynamic title and permalink.
  - **Service highlight** (1385): the pack's IconList with one item bound to `metabox_field_highlights_text`.
  - **FAQ answer** (1386): Text bound to post content.
- **Services page 182:** a Post Loop (services, menu order, 3 per row, 32px gap) replaces the 3 static card rows.
- **Single Service template** (breakdance_template 1387, type `services`), built from the static service layout:
  - Banner bound to `banner_image`, photo to the featured image, title and intro to post title and content, second photo to `detail_image`.
  - Sidebar = Post Loop of services.
  - Highlights = Dynamic Data Loop on `metabox_group_highlights`.
  - FAQs = Post Loop (accordion) with a PHP query on the `faq_to_service` relationship to the current service.
  - The hidden download box and team section are dropped.
- **FAQs page 204:** the static FAQ element is replaced by a Post Loop (accordion) of General FAQs.
- **Global CSS:**
  - "Cura: cards": the card box and icon square, matched to the pack column and IconBox.
  - "Cura: loops": zero loop-item padding for Cura blocks, and FAQ-loop styling matched to the pack's FAQ element (#F3F6F9 closed, navy open, plus/minus icons, 10px gap).
- **Stays static on purpose:** Home's 3 service summary boxes (curated combined copy) and Book a Ride's "Who we help" cards (ride types, not services).
- **Gotchas:**
  - Any property string containing `[breakdance_dynamic ...]` renders dynamically, including image and background-image values.
  - Text bindings need `<prop>_dynamic_meta`; URL bindings need `link.dynamicMeta`.
  - Global settings are stored double-JSON-encoded, and stylesheet CSS sits under `code`.
  - Don't iterate `($x['children'] ?? [])` by reference; it's a temporary copy.

## Reviews (2026-09-23): SAMPLE placeholders
- **The 27 reviews supplied 2026-09-23 are placeholders, not rider feedback.** The zip README says the headshots are synthetic people who "should not be presented as genuine customer reviewers." Publishing them as real would break the CLAUDE.md accuracy guardrail and the FTC's 2024 rule on fake and AI-generated reviews.
- **Data:**
  - 27 `review` posts in review category **Sample (placeholder)** (`sample`).
  - Fields: `review_body`, `persons_name`, `reviewer_avatar`, and `source` = "Sample placeholder". No star ratings, because none were supplied.
  - Each is linked to its service through a new Meta Box relationship, **`review_to_service`** (mb-relationship 1399).
  - Headshots are in pCloud `05-Photos/reviewers-SAMPLE-synthetic/`, with alt text marking them synthetic.
- **Breakdance:**
  - **Review card** global block (1454): the pack's avatar, quote and name elements bound to the review fields. (The visible "Sample review" tag was removed at Clint's request on 2026-09-23. Samples stay local-only through the category guard.)
  - **Service line:** a nested Post Loop of the services connected to the review (PHP query `relationship from get_the_ID()`), repeating block **Review service name** (1456), a Heading bound to `post_title`.
  - Why not Breakdance's `metabox_post_field_review_to_service_to`: Meta Box stores relationship values as a cloneable array (`["1342"]`), and Breakdance's single-post field calls `get_post()` on it, so it renders empty. Breakdance 2.8.3 also has no Meta Box relationship source in the query control (ACF only), hence the PHP query mode.
  - **Home 415:** the pack's reviews section is unhidden. Its taxi background is replaced (home-rider photo), the label is Tint, and a Post Loop shows 3 random reviews.
  - **Single Service template:** the same section is inserted after the main content (class `cura-reviews-section`), showing that service's reviews via the relationship.
- **Launch guard:**
  - Every review loop adds `tax_query NOT IN sample` unless `wp_get_environment_type() === 'local'`.
  - A Code Block in each section hides the section when its query is empty.
  - On the live site the sections therefore disappear until real reviews exist. Verified: the non-local query returns 0.
- **Source and rating (2026-09-23):**
  - Samples rotate `source` Google/Facebook/Yelp (16/6/5), with `review_platform_icon` set to the matching `fa-brands` icon and `number_of_stars` at 4 or 5 (20 five-star, 7 four-star). This is layout test data only; the local-only guard still applies.
  - **On the card:** a centered row below the avatar. It holds a Code Block for the platform icon (`rwmb_the_value()` returns inline SVG; Breakdance's field returns only the FA class, and the site loads no Font Awesome CSS) and a Breakdance **Star Rating** element, with its rating bound to `metabox_field_number_of_stars` and its label to `metabox_field_source`.
- **To add a real review:** create a Review post (not in Sample), fill the fields, and link its service. It shows everywhere automatically. Delete the 27 samples before launch.
- **Scripts:** `website/build/cura-reviews-data.php` (+ `cura-reviews-list.php`) and `cura-reviews-build.php` (+ `review-card-props.json`).

- **Headshots remapped (Clint approved):** the supplied zip had 16 of 27 portraits swapped relative to their names. They're reassigned by apparent gender and age, and the pCloud files renamed so each filename matches its reviewer.
  - Alexis (a unisex name) takes a man's portrait, because there were 13 women's portraits for 14 traditionally female names.
  - The original assignments are still in the untouched zip in Downloads.
  - The old media was deleted and re-uploaded via `cura-reviews-data.php`.
- **Reviews page `/reviews/`** (page 202, the pack's Testimonial layout), published and added to the Primary menu between FAQs and Contact:
  - The standard interior banner (dynamic title and breadcrumb) with a Cura photo.
  - Section 108 keeps the pack's row container (Div 115). Its 3 static rows are replaced by one Post Loop of all reviews (newest first, 3 per row, 32px gap) using the **Review card** block.
  - A **Reviews empty** block (1485) shows a short note when no reviews qualify (the live site before real reviews exist).
  - Same local-only sample guard as the other review loops.
  - Script: `website/build/cura-reviews-page.php`.

## Card buttons pinned to the bottom (2026-09-23)
- Global stylesheet **"Cura: card buttons"** (separate from the build-script stylesheets, so re-runs don't overwrite it). Cards with a button or link fill their height and push the button to the bottom with `margin-top:auto`, so buttons align across a row whatever the text length. The pack's minimum gap is kept: text `margin-bottom` is 20px on IconBox and 15px on ImageBox.
- **Covers:**
  - Loop cards (`.cura-card` in a Post Loop item), e.g. the Services grid.
  - Static IconBox and ImageBox cards in Columns: Home service boxes 515–519 and the Book a Ride "Who we help" cards.
  - The ride-option tables' "Book a ride" buttons (columns containing Business Hours).
- **Verified:** equal button baselines in every row on Services, Home and Book a Ride. The Rates buttons keep the pack's 15px overhang below the card.

## CPT single templates: Policies, Forms, Confirmations (2026-09-23)
- **Pattern** is taken from Clint's Elementor sites: LSS "Single Policy" 1665 and "Single Form" 1799, Tiger Town "Single Confirmation" 2607, Red White & Clicks confirmation 1510.
  - Interior banner with dynamic title and breadcrumb.
  - **66/33 row:** content on the left; **sticky sidebar on the right** (top 150px, static below 1024px).
  - Sidebar: a **Get in touch** card (Phone, Email, Service area, **Book a ride** button), then a card of **link buttons**.
- **Built from** the Single Service template's structure (sidebar cards, teal link buttons, spacing), with columns re-sized and re-ordered:
  - **Single Policy** (1487, type `policies`): the post title, then the post content in `.cura-prose`. Link buttons: all policies.
  - **Single Form** (1488, `forms`): "Request form" label, the title, the excerpt as intro, then the post content (form shortcode or block) in a white card. Link buttons: services.
  - **Single Confirmation** (1489, `confirmation`): the post title as label, "Thank you. We got your request.", next steps (review, confirmation call, price before booking), 911 line, then **Back to home** and **Call** buttons. Link buttons: services. The Confirmation type has no editor, so this copy lives in the template.
- **Global stylesheet** "Cura: CPT templates" (sticky sidebar, contact card, prose, form card, button row).
- **Script:** `website/build/cura-cpt-templates.php`.
- ⚠️ **Content still to do:**
  - The 5 policies are **other clients' text** ("PinkLine Systems", "Chronicle Jets, LLC", charter references). They must be rewritten for Cura Mobility Services, LLC and reviewed before launch.
  - The 4 forms (Consultation, Estimate, Quote, Appointment) and their confirmations are blueprint placeholders with no form content. They need Cura equivalents (e.g. Request a ride, Recurring rides, Facility inquiry), the WS Form or Breakdance form, and redirects to their confirmations.
  - Confirmations should be noindexed in SEOPress.
- **Forms wired (2026-09-23):** the form posts were empty; the blueprint never put its WS Form shortcodes in them. Now:

  | Form post | WS Form |
  |---|---|
  | Free Quote 40 | `[ws_form id="1"]` Request Quote |
  | Free Estimate 39 | `[ws_form id="1"]` Request Quote (no estimate form exists) |
  | Free Consultation 38 | `[ws_form id="5"]` |
  | Request Appointment 33 | `[ws_form id="2"]` |

  - **WS Form actions** (from the blueprint): save the submission, email `#blog_admin_email` (= clint@blaksheepcreative.com ⏳ switch to Michael at handoff), and redirect to `/confirmation/<slug>/`.
  - **Gaps:**
    - Contact Us (form 4) redirects to `/confirmation/contact/`, which doesn't exist.
    - Estimate uses the Quote form, so it redirects to the Quote confirmation.
    - The WS Form fields are generic blueprint fields (address, "new client?"), not Cura's ride-request fields.
    - WS Form's default skin (black-bordered inputs) doesn't match the site's forms yet.
- **Form ledes and styling (2026-09-23):**
  - Each form post's **excerpt** is its lede, shown between the title and the form (`.cura-form-lede`, 18px/1.6):
    - Quote: "Tell us about the ride you need. We will call you with a clear price before anything is booked."
    - Estimate: "…we will get back to you with an estimate for the ride."
    - Consultation: "Not sure which ride fits?…"
    - Appointment: "Let us know when you would like to talk…"
  - **WS Form styled to match the site's Breakdance forms** via the global stylesheet **"Cura: WS Form"**, which sets WS Form's own `--wsf-*` CSS variables on `body .wsf-form` and so applies to every WS form:
    - Fields: #F3F6F9 fill and border, 10px radius, 12px/16px padding, navy text and 500-weight labels, 16px grid gap. Focus: white with a Teal Deep border and ring.
    - Button: navy, 17px/600, 10px radius, Teal Deep on hover.
    - Required and error marks: #B91C1C.
    - Checkboxes and radios are drawn on the input (`appearance:none`), so they get a gray #7A8594 edge, a 4px radius, and navy when checked.
    - This WS Form version uses the newer Styles/CSS-variable system. The legacy skin options were also set to the Cura palette, but they aren't what renders.

## Sentence case pass (2026-09-23)
- **Decision:** headings, titles and labels stay in **sentence case**, per the brand guide (readability for older riders, the warm voice, and one simple rule for editors). Proper nouns keep their capitals.
- **Normalised:**
  - Page titles: About us, Contact us, Book a ride.
  - Form and confirmation titles: Free quote, Free estimate, Free consultation, Request an appointment.
  - Policy titles: Privacy policy, Terms and conditions, Cookie policy, Website disclaimer, Accessibility statement.
  - WS Form field labels (18 fields: First name, Last name, Email address, Address line 1/2, Postal code, ZIP code, How can we help you?, Your inquiry), plus the "Address Line1" typo. All 5 forms republished.
  - Slugs are unchanged.
- The Breakdance headings were already sentence case; a scan found no title-case holdouts.
- **Footer "Privacy policy"** was pointing at the WordPress default page 3 (`/privacy-policy/`, published and **empty**). It now links to `/policies/privacy-policy/`, and page 3 is set to draft. `wp_page_for_privacy_policy` still points at page 3.

## One H1 per page (2026-09-23)
- **Duplicate titles removed:** the Single Service (1387), Single Policy and Single Form main columns no longer repeat the hero title. On forms the "Request form" eyebrow was dropped too, so the lede leads.
- **Heading tags fixed:** Breakdance's Heading defaults to `<h1>` when no tag is set, and the pack left most headings untagged (Home had 11 `<h1>`s, other pages 3 to 9). Every untagged heading now has a tag:
  - `<h3>`: card and item titles (ride-option table titles, service feature titles, sidebar card titles "Our services" / "Our policies").
  - `<p>`: "Call or text:" and the owner-quote names.
  - `<h2>`: the confirmation's "Thank you. We got your request."
  - Global stylesheet **"Cura: headings"** keeps `p.bde-heading` in Montserrat, so nothing changed visually.
- **Verified:** a crawl of 22 public URLs (all pages, all 9 services, policies, forms, confirmation) finds exactly one `<h1>` on each, the hero title, and no heading repeating it.
- **Rule going forward:** only the hero or banner title is `<h1>`. Always set a tag on new Heading elements: `h2` for sections, `h3` for cards and items.

## Call-only (2026-09-23)
- **Cura is call-only**, per Clint: for NEMT, bookings need a conversation. Removed:
  - The **Text** (`sms:`) buttons on Home (192) and About (176).
  - Every "call or text" / "call, text or…" phrase in:
    - Breakdance: footer CTA, Home/About icon boxes and CTA text, Contact intro, reviews-empty note, confirmation template.
    - All 10 ride-option "Booking" rows (now "Call or online").
    - 7 FAQ answers.
    - The recurring-rides highlight (now "Easy changes by phone").
  - The build scripts and service content file are patched too, so re-runs stay clean.
- **Rule:** a button or link names its one action. `tel:` → "Call" / "Call (225) 363-0845". No texting language anywhere on this site.
- **Verified:** a rendered-HTML crawl of 20 URLs finds no `sms:`, "text us", "call or text" or Text buttons.

## FAQs x5, no Gutenberg, reviews spacing (2026-09-23)
- **5 FAQs per service** (45 service FAQs + 9 General = 54). 2 new per service are in `website/build/cura-faqs-extra.php`, linked via `faq_to_service` and ordered 1–5. The copy sticks to claims already on the site (no vehicle equipment, contracts, pricing or schedule promises), and hospital discharge adds "drivers do not provide medical care".
- **No Gutenberg on Services or FAQs:**
  - The `editor` support is removed from both CPTs (Meta Box post types 31 and 19).
  - New **Intro** field (wysiwyg) is the first field in Service Content. Each service's intro moved there, and `post_content` is emptied.
  - FAQ answers use the blueprint's existing **Answer** field.
  - Bindings: Single Service text 129 → `metabox_field_intro`; the **FAQ answer** block (1386) → `metabox_field_answer`, which covers the service FAQ loops and the FAQs page.
- **Data-script fix:** `cura-data.php` still read each service's card text and icon from the Services page's old static icon boxes. Those are now a loop, so a run blanked the excerpts and icons. It was caught in the same session and restored. The card text and icons now live in the script (`$cards`), and General FAQs are only upserted from an optional `cura-faqs-general.php`.
- **Reviews overhang:** the pack's review row uses a `-100px` bottom margin with a 0 bottom-padding section, which is meant to hang into the next section. Home keeps it (the next section absorbs it; 70px clear). The **Single Service template's** copy now has 70px bottom padding and no negative margin, so it no longer covers the footer CTA (set in `cura-reviews-build.php`).
- **Footer logo (2026-09-23):** Footer 244 image 117 now uses the **no-book** horizontal on-navy logo (`brand/assets/no-book/png/cura-logo-horizontal-on-navy-1200.png`, attachment 1511). The header still uses the logo with the book (1280) until Michael decides (ask #9).

## Footer bar: BlakSheep standard (2026-09-23)
- Footer 244 bottom bar (section 143 > Columns 172, class `cura-footer-bar`), matching tigertownconstruction.com:
  1. **Copyright:** dynamic year, "© 2026 Cura Mobility Services. All rights reserved." (existing text 176).
  2. **Links:** Privacy · Cookies · Terms · Accessibility · Sitemap (capitalized, not all caps) → `/policies/*/` and `/sitemap/`.
  3. **Credit:** "Powered by" plus the **all-white** BlakSheep logo SVG (attachment 1514; `brand/assets/credits/blaksheep-creative-all-white.svg`, made from BSC's logo with the #61CE70 wordmark set to white; alt "Website & SEO by BlakSheep Creative"). It links to https://blaksheepcreative.com/services/web-design-development/baton-rouge/ in a new tab; BSC has no healthcare industry page.
- **New Sitemap page** `/sitemap/` (1513): Single Policy layout with the SEOPress HTML sitemap (`[seopress_html_sitemap]`, Breakdance Shortcode element). It lists 30 links.
- The SVG is registered directly as an attachment (WP blocks SVG uploads). Source: `brand/assets/credits/blaksheep-creative-white.svg`.
- Global stylesheet **"Cura: footer bar"**: flex space-between, white text, stacked on mobile.
- **Gotcha:** the Image element's link uses `{link_type:'url', url, new_tab:true}`, not the Button's `{type, openInNewTab}`.
- Script: `website/build/cura-footer-bar.php`.
- **Footer Helpful links:** "Privacy policy" (button 130) removed on 2026-09-23; the bottom bar now carries the policy links.

## Policies rewritten for Cura (2026-09-23)
- All five policies (Privacy 47, Terms 48, Cookie 49, Website disclaimer 1195, Accessibility 1198) are rewritten for **Cura Mobility Services, LLC**. The blueprint text named "PinkLine Systems" (CRM/automation, with BlakSheep's office address as its map link) and "Chronicle Jets, LLC" (jet charter broker, with a private Ocala address and a personal Gmail). All of that is removed.
- **Cura-specific content:**
  - What a ride request collects (rider/caregiver, pickup/destination, appointment times, mobility needs). Health-related details are used only to plan the ride; no medical records, diagnoses or insurance numbers are requested; no HIPAA claims.
  - Not an emergency service (call 911). The website doesn't book a ride; rides are confirmed by phone with the price before booking. Drivers are not medical providers.
  - Medicare/Medicaid information is general only, so check your plan. Reviews reflect individual experiences.
  - Accessibility: WCAG 2.2 AA as the guide, and you can always book by phone.
- **Removed:** the California (CCPA) sections, replaced with a general "Your choices" section.
- **Contact block:** Cura Mobility Services, LLC · Serving the Baton Rouge area · phone · info@curamobility.org. No street address (records-check guardrail) and no website line, to avoid baking in the local domain.
- Gutenberg blocks (headings, lists, a table) so the policies stay editable. Sources and generated HTML are in `website/content/policies/`. Each policy has an excerpt; the unused `hero_image` meta was removed.
- ⏳ **Before launch:**
  1. Michael (and ideally an attorney) reviews all five.
  2. Update the **effective date** (currently September 23, 2026) to the launch date.
  3. Confirm the **info@curamobility.org** domain.
  4. Trim the "may use" tool mentions (Google Analytics, reCAPTCHA, Meta Pixel) to what's actually installed.

## WS Form "Ride request" (2026-09-23)
- **WS Form 8, "Ride request"** (`[ws_form id="8"]`) is a copy of the Breakdance ride-request form (Home 158, Book a ride, FAQs):
  - **Fields:** Rider's name, Your email, Your phone (required); Mobility needs and Trip type (same options); Appointment date (native date input); Pickup address; Destination. Button: "Request my ride".
  - **Layout:** 4/4/4, 4/4/4, 6/6 from tablet up; full width on phones.
  - **Labels:** hidden visually, kept as `aria-label`.
  - **Actions:** save submission; show "Thank you. We will call you to confirm your ride."; email clint@blaksheepcreative.com ⏳ (switch to Michael at handoff), with reply-to the rider's email and subject "New ride request from [name]".
  - **Build:** `website/build/cura-wsform-ride-request.php`, via WS Form's API from the Newsletter form's object. Re-running deletes and recreates the form, so the **id changes**; update any shortcodes after a re-run.
- **Verified:**
  - Measured side by side at 1030px: identical widths (333/507/1030) and heights (46px fields, 47px button). The dropdown chevrons match.
  - A test submission saved all 8 values and showed the success message. The test entry and the temporary preview page were deleted.
  - Not checked: email delivery.
- **Styling** ("Cura: WS Form" stylesheet) now also sets the 46px control height, the button padding, dark-ink placeholders, and a Breakdance-style chevron on `span.wsf-select-arrow` (WS draws a border-triangle there and forces `background-image:none !important` on selects).
- **WS Form global setting:** `ui_datepicker = native`, so all WS date fields use the browser's date input.
- **Breakdance forms** now inherit the site font; their controls were falling back to Arial and monospace.
- **Gotchas:**
  - When cloning a WS form object, don't strip `id` recursively. Data-grid options need their column and row ids, or the options render blank.
  - `label_render` off hides a submit button's text.
- **Ride request forms swapped to WS Form (2026-09-23):**
  - Home 158, Book a ride 123 and FAQs 161 were Breakdance FormBuilders. Each is now a Shortcode element (same node id, class `cura-ride-form`) with `[ws_form id="8"]`.
  - The white card is on the parent Div (25px padding, 20px radius, shadow), so the layout is unchanged.
  - Verified on all three: WS form present, fields 333/507 wide, options populated, 25px card padding top and bottom. No Breakdance ride forms remain.
  - Added `body .wsf-form .wsf-tile.wsf-bottom{margin-bottom:0}` to "Cura: WS Form": WS spaces rows with a bottom margin on every tile, which left 41px under the button.
  - The footer "Stay in touch" sign-up is still a Breakdance form.
- **Footer sign-up swapped to WS Form (2026-09-24):**
  - Footer 244 node 142 (Breakdance FormBuilder, "Email updates") is now a Shortcode element (class `cura-footer-signup`) with `[ws_form id="3"]`. That's the blueprint's Newsletter Signup, updated in place and renamed **Email updates**:
    - Field: email, required, label hidden (`aria-label` "Email"), placeholder "Enter your email" (sentence case; was "Enter Email").
    - Button: "Sign up".
    - Both fields full width; the blueprint's 9/3 side-by-side split at the largest breakpoint was cleared.
    - Actions: save; message "Thank you. You are on the list."; email to clint@blaksheepcreative.com ⏳ with subject "New email sign-up" and reply-to the subscriber.
  - "Cura: WS Form" gains `.cura-footer-signup` rules for the original's 10px field-to-button gap.
  - **Verified:** matches the original (246×46 field, 246×47 button, 10px gap). A test sign-up showed the success message and was deleted. **No Breakdance forms remain on the site**; all forms are WS Form.

## Confirmation template: custom fields (2026-09-24)
- **Confirmation Content** Meta Box group (1516) on the `confirmation` CPT, with the same field names as the Tiger Town build:
  - **Hero title** `conf_h1` (text, required): the banner H1. The post title stays in the breadcrumb and admin.
  - **Content** `conf_content` (wysiwyg): the thank-you message and next steps.
- **Single Confirmation (1489)** keeps the Form template layout (banner, then 66/33 with the sticky contact card and service links):
  - banner H1 104 → `metabox_field_conf_h1`;
  - main column → `metabox_field_conf_content` (`.cura-prose`), then the Back to home and Call buttons.
  - The template's hard-coded thank-you copy is removed.
- **Content** is set for quote 44, estimate 43, consultation 42 and appointment 41: a lead line, "What happens next" with 3 steps, and the call and 911 line. Call-only, no new promises.
- **Scripts:** `website/build/cura-confirmations.php` (fields and content) and `cura-cpt-templates.php` (template).
- **Verified:** all 4 confirmations render the hero title as the only H1, the breadcrumb with the post title, 3 steps, both buttons and the sidebar.
