# Claude Design Prompt: Cura Mobility Services Comprehensive Brand Kit & Design System

> **How to use:** Start a new Claude Design project. Upload the files listed in §0, then paste everything from "ROLE" down. The deliverable is (1) a live design system project (tokens, components, social/data templates, website and deck templates) and (2) a print-ready **Comprehensive Brand Kit PDF** that matches the structure and document style of the attached reference, `ATA Lopez Foundation Design System.pdf`.

---

## 0. FILES TO ATTACH

**Reference (format only, not brand):**
- `ATA Lopez Foundation Design System.pdf`: the gold-standard output. Match its **document structure, section order, page chrome, tone of documentation and level of rigor**. Do **not** borrow any of its colors, fonts, logos, content or claims for Cura's specimens.

**Cura source of truth** (repo `cura-mobility-services`):
- `brand-style-guide.md`, `brand/context.md`, `brand/voice.md`, `brand/messaging.md`
- `DESIGN.md`, `website/css-tokens.css`, `website/breakdance-global-settings.md`
- `seo/keyword-research.md` (services, service-area and page map)
- `CLIENT-ASKS.md`, `06-Reports/records-check.md` (open questions and the claims register)

**Logo assets** (`brand/assets/`):
- `svg/`: `cura-logo-stacked`, `-horizontal`, `-mark`, `-square`, `-wordmark`, each with an `-on-navy` variant
- `png/`: `favicon.ico`, `favicon-32/48`, `apple-touch-icon-180`, `site-icon-512`, `gbp-avatar-720`, `social-avatar-navy-720`, `cura-logo-horizontal-1200` (+on-navy), `cura-logo-stacked-1200` (+on-navy)
- `no-book/svg` + `no-book/png`: the identical set **without the open Bible** in the R (alternate; see §5 of this prompt)
- `cura-logo-original.jpg`: the client's original raster (master reference)

---

## ROLE

Act as a senior brand systems designer, design-systems architect, information designer, social media designer, UI designer, copy lead and production specialist for **Cura Mobility Services**, working on behalf of **BlakSheep Creative**.

Your job is to build **one coherent design system** for Cura and document it completely, so that anything made for Cura (a web page, a van magnet, a Google Business Profile post, a facility one-pager, a social carousel) looks and sounds like it came from the same caring, dependable local company. It must never look like an agency template with a logo dropped on it.

**Extend the brand that exists. Do not redesign it.** Every color, face and asset below is decided. Where something is genuinely missing, derive it from what exists, label it as derived, and list it as an open question.

---

## 1. THE CLIENT (Section 01 content: "The Context")

**Organization of record**
| Field | Value |
|---|---|
| Name | Cura Mobility Services (legal: Cura Mobility Services, LLC. Drop "LLC" in marketing.) |
| Business | Non-emergency medical transportation (NEMT) by van |
| Owner | Michael Veal |
| Phone | (225) 363-0845 ⏳ confirm it is the public business line |
| Website | curamobility.org ⏳ ownership unconfirmed |
| Base | Baton Rouge, Louisiana area. **No public street address** (service-area business) |
| Registered | LLC formed Aug 2026; NPI issued Aug 2026 ("Non-emergency Medical Transport (VAN)") |
| Stage | Pre-launch; turnkey WordPress (Breakdance) site handed to the owner |

**What "Cura" means:** *cura* is Latin for **care**. Recommended tagline: **"Cura means care."** (pending client approval). Secondary line: "On time. On your side."

**What it does** (working list, inferred from the owner's stated model; ⏳ confirm each):
Non-emergency medical rides (doctor visits, dialysis, treatments, hospital discharge) · wheelchair / ADA transport · bariatric and oversized-scooter passengers · everyday and senior rides · prescription drop-offs and medical courier · long-distance medical trips. **No stretcher service. No luxury service.**

**Who it is for**
- **Primary:** adult children and family caregivers booking a ride for a parent, often from work, on a phone.
- **Riders:** seniors, dialysis patients and people after surgery or discharge. They may be tired, in pain or anxious, and may use a walker or wheelchair.
- **Secondary:** facility schedulers (dialysis centers, discharge planners, nursing homes, case managers) who need dependable recurring pickups.

**Position:** a small, owner-operated local company that answers its own phone. **Reliability and dignity** are the differentiator: on time, a call when on the way, help from the door, and clear cost answers up front. Competitors are Uber Health / national template sites and hard-to-reach local operators with no-show complaints. Contrast by behavior; never name competitors.

**Surfaces this system must cover:** the marketing website (Breakdance/WordPress), the Google Business Profile, social, a facility one-pager/deck, print (business card, review QR card, van graphics) and email/text confirmations.

---

## 2. VOICE (Section 02: "The Voice")

**Voice essence:** *Cura sounds like a caring, steady local driver who shows up on time: warm, clear and trustworthy.*

- **Person:** second person to the reader ("We'll call when we're on the way"). "We" for Cura. Never institutional ("Cura Mobility Services is committed to providing...").
- **Casing:** sentence case everywhere: headlines, buttons, nav. Letterspaced caps only for small eyebrow labels (0.08em) and inside the logo artwork.
- **Sentences:** short and concrete, mostly under 20 words, in active voice. Contractions yes. Reading level grade 6–8.
- **Punctuation:** **no em dashes**. No exclamation marks in headlines. No ellipses.
- **Jargon:** define "NEMT" inline on first use. Explain Medicaid/Medicare plainly.
- **Emoji:** none in UI. Sparingly in social captions only.
- **Headlines state what happens:** "We'll help your dad from the door to his seat." · "Dialysis three times a week? We'll set up recurring rides."
- **CTAs name the task:** "Book a ride" · "Call (225) 363-0845" · "Set up recurring rides" · "Ask about cost". **Never:** "Learn more", "Submit", "Click here", "Get started".
- **Use:** ride, rider, driver, on time, door-to-door, appointment, pickup, loved one, family, safe, dignity, peace of mind, Baton Rouge.
- **Avoid:** solutions, premier, luxury, world-class, #1, leverage, the elderly, wheelchair-bound, handicapped, patients (outside clinical context), suffering from, guarantee.
- **On brand:** "We show up on time, help you to the door, and wait if your appointment runs long." ⏳
- **Off brand:** "Cura Mobility Services provides premier NEMT solutions across the great state of Louisiana!"
- **Honest limits are a trust asset:** "Cura provides transportation, not medical care. For emergencies, call 911." Show it at body size, never as fine print.
- **Faith:** the logo carries an open Bible and cross. Default: **the faith element lives in the logo only**, with no scripture or faith language in copy until the owner decides (⏳ ask #9).

Full rules: `brand/voice.md`, `brand/messaging.md`.

---

## 3. VISUAL FOUNDATIONS (Section 03)

**The mark sets the idiom:** a navy shield holding a white high-roof passenger van with a medical cross and caduceus, orbited by a navy-to-teal swoosh, over a heavy geometric "CURA" wordmark (teal U) and a letterspaced "MOBILITY SERVICES" tagline. It reads **protective, medical, dependable**. Design extends that: solid, rounded-geometric, calm, navy-led, teal as punctuation.

**Color (verbatim; contrast measured with WCAG 2.2):**
| Token | Hex | Role | Contrast |
|---|---|---|---|
| Cura Navy `--brand-primary` | `#02265A` | Headings, primary buttons, header/footer, inverse grounds | 14.71 on white, AAA |
| Cura Teal `--brand-secondary` | `#058D8D` | Logo, icons, illustration, display type ≥ 24px only | 4.04 on white: **large text/graphics only** · 3.64 on navy: graphics only |
| Teal Deep `--brand-accent` | `#047878` | Links, small teal text, secondary buttons, hover | 5.30 on white, AA |
| Teal Tint `--brand-tint` | `#E6F4F4` | FAQ, "who pays" and callout panels | Navy on it 13.04 |
| Mist `--bg-surface` | `#F3F6F9` | Alternate section ground, cards | Navy on it 13.56 |
| White `--bg-base` | `#FFFFFF` | Page ground | — |
| Ink `--text-primary` | `#1A2433` | Body text | 15.62, AAA |
| Slate `--text-muted` | `#5A6675` | Secondary text | 5.85, AA |
| Status | Success `#22A06B` · Warning `#E8A33D` · Error `#D9534F` | UI states only; never meaning by color alone | — |

**Ratio:** about 60% white/neutral grounds, 25% navy, 10% teal, 5% tint and status. **The only gradient in the brand is the logo swoosh (navy → teal). No UI gradients.** Show the ratio as a bar the way the reference does.

**Type** (free OFL Google Fonts, self-hosted; owner approval ⏳):
- **Montserrat** 600/700 for headings, buttons and eyebrows. Its geometric, wide letterforms echo the wordmark.
- **Atkinson Hyperlegible** 400/700 for body. The Braille Institute designed it for low-vision readers, which matters for older riders.

| Role | Token | Mobile → desktop | Face / weight |
|---|---|---|---|
| Display | `--text-display` | 40 → 56px | Montserrat 700, lh 1.1 |
| H1 | `--text-h1` | 32 → 44px | Montserrat 700, lh 1.15 |
| H2 | `--text-h2` | 26 → 34px | Montserrat 700, lh 1.2 |
| H3 | `--text-h3` | 20 → 24px | Montserrat 600 |
| Body | `--text-base` | 18px (never below 16px) | Atkinson 400, lh 1.6, measure 70ch |
| Small | `--text-small` | 14px | Atkinson 400 |
| Eyebrow | `--text-eyebrow` | 13px, uppercase, +0.08em | Montserrat 600 |
| Button | — | 17px | Montserrat 600, sentence case |

Include live specimens using real Cura lines, for example H1 "Safe, on-time rides to your medical appointments." and body copy from `brand/messaging.md`.

**Shape, borders, shadows:** radius 6px (inputs/small) · **10px buttons** · 12px cards/images · 20px large panels · 999px avatars and dots only. Border `1px rgba(2,38,90,.12)`; emphasis `2px #02265A`. Shadows are soft and navy-tinted (`0 1px 2px rgba(2,38,90,.06)`, `0 4px 12px rgba(2,38,90,.08)`, `0 12px 32px rgba(2,38,90,.10)`), used sparingly. **Cards do not lift on hover; the border goes navy.**

**Layout:** 8px base; spacing 8·16·32·64·96·128. Max width 1200px, measure 70ch, gutters 32px desktop / 20px mobile, section padding 96/64/48px. 12-column desktop, 4-column mobile. Left-aligned text. **Tap targets ≥ 48px.** A sticky mobile bottom bar with Call and Book. The phone number is visible on every page.

**Motion:** 200ms, `cubic-bezier(0.4,0,0.2,1)`. Hover is a color shift only. Press darkens. A 12px fade-up entrance, once. No parallax, bounce or autoplay. Honor `prefers-reduced-motion` globally.

**Focus and accessibility:** a visible 3px Teal Deep focus ring with 2px offset, never `outline:none`. WCAG 2.2 AA minimum, AAA on body text. The audience skews older and reads on phones in waiting rooms, so **accessibility is the brief, not a checklist.**

**Backgrounds and photography:**
- **Backgrounds:** white by default; Mist or Tint bands; navy for the footer and CTA bands. Text on photos needs a solid plate or a navy overlay at ≥ 55% (`rgba(2,38,90,.55)`).
- **Photography, always:** real, warm natural light. The actual van ⏳, the owner and drivers (with consent), hands helping at a van door, a ramp or lift in use ⏳, and riders arriving at unbranded medical buildings. Calm, kind faces.
- **Photography, never:** ambulances, sirens, emergency lights, stretchers, sterile corridors, posed thumbs-up seniors, luxury sedans or chauffeurs, taxis.
- **No client photos exist yet.** Use clearly marked placeholder frames and document an AI and stock direction. Never render the Cura logo onto a vehicle; composite official art later.

**Illustration and pattern:** minimal. Where needed, flat navy/teal shapes that echo the **swoosh curve**, for example a single orbit arc as a section divider or background motif at 5–8% opacity. Never extract or crop parts of the logo file.

---

## 4. ICONOGRAPHY (Section 04)

**Lucide**, 2px stroke, rounded, 24px default, in navy, Teal Deep or `currentColor`. Filled icons only for status. Working set: `phone`, `calendar-clock`, `clock`, `map-pin`, `accessibility`, `car`, `route`, `hand-heart`, `heart-handshake`, `shield-check`, `repeat` (recurring rides), `pill` (prescriptions), `package` (courier), `hospital` (destinations only), `message-square-text`, `check`, `info`, `alert-circle`, `arrow-right`.
**Never:** ambulance, siren or stretcher icons; emoji in UI; unicode symbols as icons. The only brand glyph is the logo mark.

---

## 5. ASSETS AND LOGO RULES (Section 05)

Render the **asset inventory** as a grid (as in the reference):
- stacked on white, stacked on navy, horizontal on white, horizontal on navy, mark, square, wordmark
- favicons 32/180/512 and ico
- Google Business Profile avatar and navy social avatar

**Include a "clear space and minimum sizes, rendered at true scale" plate** showing what survives at 200 / 160 / 120 / 96 / 64 / 32px. The caduceus and Bible detail fill in around 120px, so switch to the horizontal lockup, or to the mark below 96px.

**Rules:**
- Use the official files only. Never redraw, recolor, rotate, stretch, crop, extract from, add effects to, AI-recreate, or re-set the wordmark as live text.
- The full-color logo goes on white or light neutrals only. On navy, use the `-on-navy` files.
- Clear space equals the height of the "U" in CURA on all sides.
- Minimum widths: stacked 160px, horizontal 180px, mark 32px.
- Show a **file tree** of `brand/assets/`.

**Honesty callouts:**
- **Traced, not original.** The only client file is a 1170×692 raster (likely AI-generated). The SVG set is BlakSheep's trace, with the swoosh gradient rebuilt as a true SVG gradient. It is web-grade. Print, signage and van wraps need the owner's originals or a professional redraw (⏳ ask #11).
- **Two approved variants pending the faith decision:** *with Bible* (default, the owner's artwork) and *no-book* (R and A letterforms redrawn by BlakSheep). Show both side by side and mark the no-book set "Derived, requires owner sign-off".
- **Still missing:** a one-color logo (for embroidery or single-color print). Do not fake it by filtering.
- **Symbol note:** the caduceus is common in US medical branding; keep whatever the owner prefers.

---

## 6. PHOTOGRAPHY AND CONSENT (Section 06)

- Written consent before any rider appears in a photo, testimonial or story. **Never show health details** or identifiable riders at medical facilities without consent.
- Facility exteriors: no hospital or clinic logos or signage unless there's a partnership.
- Provide an **AI image prompt framework** (subject, action, environment, van details, camera, lighting, composition, color grade, authenticity, avoid), with 3 worked Cura examples: a driver helping a senior at a white van with a ramp at golden hour; a daughter on the phone booking a ride for her mom at the kitchen table; a dialysis rider arriving at an unbranded clinic entrance. Rules: plain white van, no invented logos or text on vehicles, correct wheelchair securement, no ambulance cues.

---

## 7. PROHIBITED CLAIMS: OVERRIDES EVERYTHING ELSE (Section 07)

Open the document with a callout: **"Read Section 7 first if you are shipping today."**

**Prohibited until verified with documents:**
- licensed / Medicaid provider / Medicaid-approved / MediTrans or Verida network
- insured / bonded
- statewide / all of Louisiana
- any years in business (the LLC is under 1 year old) or "decades of experience"
- ride counts, rider counts, star ratings, review counts, awards
- drivers "certified" (CPR, first aid, PASS)
- "24/7" or same-day guarantees
- any public street address

**Always prohibited:**
- emergency implications (ambulance, replaces 911)
- medical advice
- naming or disparaging competitors
- the consultant's (Mitresonz) brand language or assets
- fabricated testimonials or statistics

**Approved now:** owner-operated by Michael Veal · a Baton Rouge-area company · a registered non-emergency medical transportation provider (NPI on file; never implies Medicaid enrollment) · door-to-door help and ride confirmations **only once the owner confirms these are real practices**.

**Payer facts to state carefully:** Original Medicare generally doesn't cover van rides to appointments. Louisiana Medicaid rides are arranged through the member's health plan and brokers. **Broker phone numbers conflict between sources; do not publish any until verified on ldh.la.gov.**

**All sample data in specimens must be labeled "Sample data".**

---

## 8. COMPONENTS: THE CONTRACT (Section 08)

Build these as real components with variants, all bound to tokens. Document each in a table ("Component / What it is for") and render live specimen plates grouped as in the reference.

- **Core:** `Button` (primary solid navy · secondary outlined phone button · inverse on navy · link) · `Icon` (Lucide wrapper) · `Logo` (encodes minimum sizes and approved grounds, with a with-book/no-book prop) · `Badge` · `Tag`
- **Navigation:** `ContactBar` (navy strip: "Call us to book a ride." + phone) · `SiteHeader` (horizontal logo, nav, outlined phone, solid "Book a ride") · `MobileActionBar` (sticky Call + Book, equal width) · `SiteFooter` (navy, stacked on-navy logo, service area, hours, the "For medical emergencies, call 911" line)
- **Booking:** `RideRequestForm` with fields: rider name · your phone (required) · pickup address · destination · date · appointment time · round trip? · mobility needs (walks / walker / wheelchair / scooter / bariatric) · recurring? · notes. Include default, error and success states. Errors are stated in words, never by color alone. Plus the `BookingHero` composition: a photo hero with the form overlapping it (the owner's reference sites all use this pattern)
- **Content:** `ServiceCard` (named as tasks: "Rides to dialysis", "Hospital discharge rides", "Wheelchair-accessible rides") · `StepList` ("How booking works": call or request → we confirm → we pick you up → we get you home) · `WhoPaysCallout` (Tint panel explaining private pay / Medicaid / Medicare) · `InlineDefinition` (NEMT) · `ServiceAreaList` (parishes ⏳) · `FAQAccordion` · `TrustStrip` (verified items only) · `EmergencyDisclaimer` · `CTABand`
- **Families and social:** `StatBlock` (always with a source line) · `QuoteBlock` · `ReviewCard` (Google style; placeholder until real reviews exist) · `ChecklistBlock` ("What to bring to your appointment") · `ComparisonBlock` (van ride vs ambulance vs rideshare) · `MythFactBlock` · `KPIGrid`
- **Data:** bar, line, donut, ranking, progress, timeline, comparison matrix, sparkline and heat map, all using the derived data palette (below)

**BlakSheep CTA standard (non-negotiable):**
1. The phone is a real **button**, never a bare link.
2. The phone is the **secondary** action (outlined); "Book a ride" is primary (solid).
3. Paired buttons are **equal width**: column, stretched, capped at 520px.

Close the section with **"Intentional additions"**: explain, as the reference does, why each component beyond the basics exists. None may introduce a new color, face or treatment.

---

## 9. SOCIAL, VIDEO AND DATA CONTENT SYSTEM (Section 09)

Apply the full **Universal Client Social Media Template System** architecture, with Cura as the active client:

- **Token flow:** client design system → social content system (formats, safe zones, social type, data palette) → content family → platform format → final asset.
- **Master formats:** square 1080×1080 · portrait 1080×1350 · story 1080×1920 · tall 1000×1500 · link 1200×630 · widescreen 1920×1080 · thumbnail 1280×720 · banner 1500×500 · ultra-wide 1584×396 · GBP update 1200×900.
- **Per-platform specs:** Instagram, Facebook, LinkedIn, X, Threads, Bluesky, TikTok, YouTube, Pinterest, **Google Business Profile (priority)** and Nextdoor. Keep them in one central Platform Specifications table with safe zones and crop behavior. Mark it "verify before a large campaign".
- **Rules that are not negotiable:**
  - Recompose, never resize.
  - Every number carries a source.
  - Never use color alone.
  - Restraint, consent and no invented numbers.
- **Content families with Cura sample content** (realistic, not lorem, no fabricated stats):
  - Statement: "Mom's appointment is covered."
  - How it works, as a 4-step carousel.
  - Myth vs fact: "Medicare pays for rides to the doctor" (Myth) → "Original Medicare generally doesn't cover van rides; here's what can help." (Fact, with a source line)
  - Checklist: what to bring to dialysis.
  - FAQ: "How far ahead should I book?"
  - Comparison: van vs ambulance vs rideshare.
  - Announcement: "Now booking rides in [parish] ⏳".
  - Review template (placeholder until real reviews exist).
  - Facility partner post: "Set up recurring rides for your patients."
  - Hiring: drivers.
- **Avatar system** built from the mark (square and circular crops at 32/64/128/256).
- **Data palette:** derived only from brand colors: navy `#02265A`, Teal Deep `#047878`, Cura Teal `#058D8D`, Slate `#5A6675`, and tints of navy/teal for ramps. Series must also differ by label, dash or symbol. Label all specimen data "Sample data".
- **Social type scale** by role and format, e.g. `social.square.headline` about 76px, with a body floor of 34px on feed graphics.
- **Footer:** compact, with the mark, phone and website only (⏳ confirm the domain).

---

## 10. DECK AND WEBSITE TEMPLATES (Section 10)

- **Website (Breakdance/WordPress, turnkey handoff):** templates for Home, a service page (for example "Wheelchair transportation in Baton Rouge"), Who pays / Cost, FAQ, Service areas, For facilities, Book a ride, and Contact.
  - The page map is in `seo/keyword-research.md`.
  - **The homepage skeleton follows the owner's references:** a contact bar → header with outlined phone plus "Book a ride" → a booking hero (real van photo, "Non-emergency medical rides in Baton Rouge, with care.", the form overlapping it) → how it works (4 steps) → service cards → who we serve (families | facilities) → why Cura (verified trust tiles only) → where we go (Baton Rouge destinations and parishes ⏳) → reviews (once real) → FAQ → CTA band → footer with the 911 line.
  - Note that the build uses the Pixels Library **Cab Service** and **Senior Care v2** Breakdance packs, re-themed through the Global Settings mapping in `website/breakdance-global-settings.md`. Designs must be achievable in Breakdance.
- **Deck:** a "facility partner" deck template for dialysis centers and discharge planners (title, who we are, services, how scheduling works, service area, contact). Plus a general 16:9 master: title, section, content, stat, quote and closing layouts.
- **Print:**
  - Business card: front, and a navy back with a review QR code.
  - A 4×6 "How was your ride?" review QR card.
  - A van magnet/door-graphic layout, marked "requires print-grade vector".

---

## 11. TOKEN APPENDIX: VERBATIM SOURCE (Section 11)

Reproduce `website/css-tokens.css` **verbatim** in a code block, plus the social tokens you create (formats, safe zones, social type, data palette), so the system can be rebuilt from this document alone if every other file is lost. Include the Breakdance palette-slot mapping table from `website/breakdance-global-settings.md`.

## 12. FILE INDEX (Section 12)

A file tree of the design system project and `brand/assets/`, explaining what lives where.

## 13. OPEN QUESTIONS: ASK BEFORE FINALIZING (Section 13, "Blockers")

Number them, as the reference does:
1. Which domain does the owner control (curamobility.org / .com)?
2. Confirm the service list (ambulatory, wheelchair, bariatric, dialysis, discharge, long distance, prescription/courier; no stretcher).
3. What does "e-commerce" mean: online ride payment, equipment, or merchandise?
4. Payer model: private pay, Medicaid through brokers, or both? Any MediTrans/Verida enrollment?
5. LPSC certificate, for-hire plates, NEMT insurance: copies needed before any credential claim.
6. Public address: none (service-area) is the default.
7. Confirmed parishes and cities served.
8. Fleet: number of vans, ramp or lift, bariatric capacity.
9. **Faith element:** logo only, copy too, or the no-book logo?
10. Is Joyce Veal (NEMT, Baton Rouge) part of the business?
11. Vector originals of the logo (or approve a professional redraw).
12. Google Business Profile: existing or new; exact name.
13. Approve the tagline ("Cura means care."), the fonts (Montserrat + Atkinson Hyperlegible) and hours of operation.
14. Is the public phone (225) 363-0845?
15. Which operating promises are real (day-before confirmation, on-the-way call, waiting during appointments, recurring schedules)? These gate the key messages.

---

## DOCUMENT FORMAT (match the reference exactly)

- **US Letter, portrait.** Running header: "CURA MOBILITY SERVICES · COMPREHENSIVE BRAND KIT" left, "PREPARED BY BLAKSHEEP CREATIVE" right. Running footer: "CONFIDENTIAL · CLIENT BRAND DOCUMENTATION" left, "EDITION 1.0 · [MONTH YEAR]" right.
- **Document chrome is BlakSheep's house style, as in the reference:** the dark cover, the "Prepared by BlakSheep Creative" logo block, the accent rule and section-number color. **All specimens, swatches and templates inside use Cura's tokens only.** Never mix the two inside a specimen.
- **Cover:** eyebrow "BRAND SYSTEM DOCUMENTATION · EDITION 1.0", "CURA MOBILITY SERVICES", title **"COMPREHENSIVE BRAND KIT."**, a one-paragraph summary (non-emergency medical rides for Baton Rouge-area families; reliability and dignity; turnkey Breakdance site), and the tagline line "Cura means care." Then a meta strip: Client / Prepared by / Scope / Issued.
- **"About this document" page** with a confident headline in the reference's style (for example "NO FLUFF. NO JARGON. JUST THE BRAND."), who made it, how to use it (sections 1–7 are brand law, 8 is the component contract, 9–10 are content and templates, 11–12 are source, 13 is blockers), and a **Contents** table with those labels.
- **Section openers** are dark panels: "Section 0X" plus a two-tone title ("THE CONTEXT.", "THE VOICE.", "VISUAL FOUNDATIONS.", "ICONOGRAPHY.", "THE ASSETS.", "PHOTOGRAPHY & CONSENT.", "PROHIBITED CLAIMS.", "COMPONENTS.", "SOCIAL, VIDEO & DATA CONTENT.", "DECK & WEBSITE TEMPLATES.", "TOKEN APPENDIX.", "FILE INDEX.", "OPEN QUESTIONS.") and a one-line deck.
- **Callout types**, as in the reference:
  - neutral note
  - **Unresolved** (orange bar)
  - **Hard limit / Never** (red bar)
  - **Correction / Honesty** (green bar)
- **Tables** have a black header row and zebra rows. Code and file paths are set in monospace.
- **Rendered specimen plates** are captured live from the built components, with a caption line under each ("CORE: BUTTON, BADGE, LOGO, ICON", and so on), not redrawn.
- Target length: comparable to the reference (roughly 40–60 pages). **Export as PDF** named `Cura Mobility Services Design System.pdf`.

---

## QUALITY CONTROL (before marking complete)
- [ ] Every hex, size and token matches §3 and `css-tokens.css` exactly
- [ ] Official logo files only; with-book and no-book variants are labeled correctly; no logo on dark grounds except on-navy files
- [ ] Cura Teal `#058D8D` is never used for small text
- [ ] No prohibited claim anywhere, including sample content and specimens
- [ ] Every statistic has a source line, or is labeled "Sample data"
- [ ] No ATA Lopez colors, fonts, content or assets survive in any Cura specimen
- [ ] CTA standard applied: the phone is an outlined button, equal widths, 520px cap
- [ ] No em dashes in Cura copy; sentence case; no "Learn more"
- [ ] Contrast, focus and tap-target rules are visibly demonstrated
- [ ] Social formats are recomposed, not resized; safe zones are shown
- [ ] Open questions are listed, not guessed

**Success looks like:** someone who has never met Michael could build a Cura page, post or van magnet from this document alone, and it would look like it came from one calm, dependable local company that genuinely cares.
