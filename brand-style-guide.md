# Cura Mobility Services: Brand Style Guide

**Version:** 1.0 (draft) · **Date:** 2026-09-22
**Prepared by:** BlakSheep Creative (Clint Sanchez) · **For:** Michael Veal, Cura Mobility Services
**Source package:** `brand/` (`brand.yaml`, `context.md`, `voice.md`). Tokens are kept identical in `DESIGN.md` and `website/css-tokens.css`.

> ⏳ marks items that wait on client answers (CLIENT-ASKS.md) or on vector logo files. Accuracy guardrails apply to every public word: no "licensed", "Medicaid provider", "statewide", tenure or invented numbers until verified.

---

## Part 1 · Brand foundation

### About this guide
This guide is for anyone who designs or writes for Cura: BlakSheep during the build, and Michael after the turnkey handoff. It covers how the logo, colors, type, photos and words should look and sound so the website, van graphics, cards and Google profile all feel like one trustworthy company. When in doubt, choose the clearer, calmer option.

### Brand essence
- **Mission (draft ⏳):** Get Baton Rouge families where they need to be for their health, safely, on time and treated like family.
- **Vision (draft ⏳):** To be the ride Baton Rouge families recommend first when someone they love can't drive to care.
- **Values (draft ⏳):**
  - **Dignity:** every rider is treated as a person, never a "case".
  - **Reliability:** on time, every time, and a call when plans change.
  - **Compassion:** patience at the door, in the van and at the clinic.
  - **Honesty:** clear prices, clear answers, no inflated claims.
  - **Community:** a local company serving its neighbors.
- **Personality:** dependable, caring, respectful, friendly, steady.
- **Positioning statement:** For Baton Rouge families who need a safe ride to medical care for someone they love, Cura Mobility Services is the local, personal van service that shows up on time and treats riders with dignity. Unlike national ride platforms and hard-to-reach operators, Cura answers its own phone, explains who pays in plain words, and helps riders door to door.

---

## Part 2 · Visual identity

### Logo
- **Primary logo:** a stacked lockup. A navy shield holds a white van with a medical cross and caduceus, circled by a teal-to-navy swoosh. Below it sits the "CURA" wordmark (navy C-R-A, teal U, an open Bible with a cross inside the R) over the teal tagline "— MOBILITY SERVICES, LLC —".
- **Files on hand** (`brand/assets/`, mirrored to pCloud `01-Brand-Assets/`):
  - `cura-logo-original.jpg`: the client raster, 1170×692. It is the master reference.
  - `svg/`: traced vector set in navy/teal/white. The swoosh uses a real navy-to-teal linear gradient, as in the original.
    - `cura-logo-stacked`: primary.
    - `cura-logo-horizontal`: website header.
    - `cura-logo-mark`: the shield alone.
    - `cura-logo-square`: the mark centered in a square, for icons.
    - `cura-logo-wordmark`: CURA plus the tagline.
    - Each comes in an `-on-navy` version for navy backgrounds: navy becomes white, the tagline is white for contrast, and the swoosh runs white to teal.
  - `png/`:
    - Favicons: `favicon.ico` (16/32/48), `favicon-32`, `favicon-48`.
    - Icons: `apple-touch-icon-180` and `site-icon-512` (WordPress Site Icon).
    - Avatars: `gbp-avatar-720` (Google profile) and `social-avatar-navy-720`.
    - Logos: transparent `cura-logo-horizontal-1200`, `cura-logo-stacked-1200` and their on-navy versions.
  - `no-book/svg` + `no-book/png`: **the same full set without the open Bible**. The R is redrawn with a straight diagonal leg and the A with a symmetric left leg, with a proper gap between them. Use this set if Michael wants the faith element off (ask #9). The mark and icons are identical in both sets.
  - The trace is web-grade. ⏳ For print, signage or van wraps, get Michael's vector originals (ask #11) or budget a clean redraw. The logo appears AI-generated, so originals may not exist.
- **Variations to produce** (from the vector, once available):
  - Full-color stacked (primary).
  - Horizontal: shield mark left, wordmark right. Use it in the website header.
  - Mark only: the shield. Use it for the favicon, Google profile avatar and social avatar.
  - Wordmark only: CURA plus tagline.
  - Reversed: all-white, for navy backgrounds.
  - Drop ", LLC" from the tagline on marketing versions ("MOBILITY SERVICES"). Keep it on legal documents.
- **Clear space:** the height of the "U" in CURA on all sides.
- **Minimum size:** stacked 160 px wide on screen and 1.5 in in print. Horizontal 180 px. Mark-only 32 px (favicon 32/180/512 exports). Below 120 px, the caduceus and Bible detail fill in, so use the mark or horizontal version instead.
- **Incorrect usage:**
  - Don't stretch, squash or rotate it.
  - Don't add shadows, glows, bevels or outlines.
  - Don't recolor it outside navy, teal and white.
  - Don't place the full-color logo on photos or busy backgrounds without a white or navy container.
  - Don't place the full-color logo on navy. Use the reversed version.
  - Don't separate the Bible from the R, or swap the cross or caduceus for other symbols.
  - Don't rebuild it with our own fonts. Always use the supplied artwork.
- **Symbol note (for the redraw):** the caduceus (two snakes) is common in US medical branding. The single-snake Rod of Asclepius is the technically "medical" symbol. Either is acceptable; keep whatever Michael prefers.

### Color palette
Sampled from the logo raster on 2026-09-22 and re-verified by k-means sampling (the JPEG core pixels measured about #032553 and #038889, matching within compression noise). ⏳ Confirm against vector files.

**Primary**

| Name | Hex | RGB | CMYK (approx.) | Pantone | Use |
|---|---|---|---|---|---|
| Cura Navy | `#02265A` | 2, 38, 90 | 98, 58, 0, 65 | ≈ 2767 C (confirm with printer) | Headlines, header/footer, primary buttons, logo |
| Cura Teal | `#058D8D` | 5, 141, 141 | 96, 0, 0, 45 | ≈ 7713 C (confirm) | Logo, icons, illustrations, large display type ≥ 24 px, accents |

**Secondary**

| Name | Hex | RGB | CMYK | Use |
|---|---|---|---|---|
| Teal Deep (text-safe) | `#047878` | 4, 120, 120 | 97, 0, 0, 53 | Links, secondary buttons, small teal text |
| Teal Tint | `#E6F4F4` | 230, 244, 244 | 6, 0, 0, 4 | Callout and FAQ backgrounds, info panels |

**Neutrals**

| Name | Hex | RGB | Use |
|---|---|---|---|
| White | `#FFFFFF` | 255, 255, 255 | Page background |
| Mist | `#F3F6F9` | 243, 246, 249 | Alternate section backgrounds, cards |
| Ink | `#1A2433` | 26, 36, 51 | Body text |
| Slate | `#5A6675` | 90, 102, 117 | Captions, secondary text |

**Status (UI only):** Success `#22A06B` · Warning `#E8A33D` · Error `#D9534F`.

**Contrast (WCAG 2.2, computed):**

| Pair | Ratio | Verdict |
|---|---|---|
| Ink on White | 15.62 | AAA body |
| Navy on White | 14.71 | AAA body |
| White on Navy | 14.71 | AAA body (reversed sections, buttons) |
| Navy on Mist / on Teal Tint | 13.56 / 13.04 | AAA |
| Slate on White / on Mist | 5.85 / 5.39 | AA body |
| Teal Deep on White | 5.30 | AA body: links, small teal text |
| White on Teal Deep | 5.30 | AA body: secondary buttons |
| Teal Deep on Mist / on Teal Tint | 4.89 / 4.70 | AA body |
| **Cura Teal on White** | **4.04** | **Large text (≥ 24 px, or 18.66 px bold) and graphics only** |
| **White on Cura Teal** | **4.04** | **Large text only. Don't use as a button fill with small labels.** |
| **Cura Teal on Navy** | **3.64** | **Graphics and large display only** (for example an outline ring on a navy CTA band) |

**Usage rules**
- Navy is the anchor at roughly 60% of color use. Teal is the accent at about 10%, and whites and neutrals make up the rest.
- Primary action ("Book a ride"): solid Navy with white text. On a navy band, use a solid white button with navy text.
- Secondary action (phone): outlined. On white, a Navy ring with Navy text. On navy bands, a white ring with white text.
- Links: Teal Deep, underlined in body copy.
- Never put small text in Cura Teal. Use Teal Deep.
- No gradients in UI. The logo swoosh is the only gradient in the brand.

### Typography
Recommendation ⏳ (client to approve). Both families are free Google Fonts under the OFL license with no subscription, which suits the turnkey handoff. Self-host them in WordPress.

- **Headings: Montserrat** (600, 700). Its geometric, wide letterforms echo the "MOBILITY SERVICES" tagline and the CURA wordmark.
- **Body: Atkinson Hyperlegible** (400, 700, plus italics). The Braille Institute designed it for low-vision readers, so letters like I/l/1 and O/0 are easy to tell apart. It's a real benefit for older riders and a quiet brand story.

| Level | Typeface | Weight | Size (mobile → desktop) | Line height | Usage |
|---|---|---|---|---|---|
| Display | Montserrat | 700 | 2.5 → 3.5 rem | 1.1 | Homepage hero only |
| H1 | Montserrat | 700 | 2 → 2.75 rem | 1.15 | Page titles |
| H2 | Montserrat | 700 | 1.625 → 2.125 rem | 1.2 | Section headings |
| H3 | Montserrat | 600 | 1.25 → 1.5 rem | 1.25 | Cards, FAQ questions |
| Body | Atkinson Hyperlegible | 400 | 1.125 rem (18 px) | 1.6 | All paragraphs; never below 16 px |
| Small / caption | Atkinson Hyperlegible | 400 | 0.875 rem | 1.5 | Captions, fine print |
| Label / eyebrow | Montserrat | 600, uppercase, +0.08em | 0.8125 rem | 1.3 | Section eyebrows, badges |
| Button | Montserrat | 600 | 1 → 1.0625 rem | 1 | CTAs, sentence case |

**Rules:** sentence case everywhere, except the uppercase eyebrow style. Body measure is 60–75 characters. Fallback stacks: `"Montserrat", "Segoe UI", Arial, sans-serif` and `"Atkinson Hyperlegible", Verdana, "Segoe UI", sans-serif`.

### Imagery
- **Photography:** real, warm, natural light. Show the actual van ⏳, Michael and drivers (with permission), hands helping at a car door, ramps and lifts in use ⏳, and riders arriving at recognizable but unbranded medical buildings. Faces show calm and kindness. Plan a half-day shoot once the van is ready. It is the single biggest trust upgrade.
- **Until photos exist:** carefully chosen stock showing local-feeling Southern settings and diverse, older riders. It must never imply Cura's own fleet, and it can't show logos or ambulances.
- **Avoid:** ambulances, emergency lights, stretchers (not offered), sterile hospital corridors, overly posed "thumbs-up" seniors, luxury sedans or chauffeurs, and anything implying emergency service.
- **Iconography:** simple line icons, 2 px stroke, rounded caps, in Navy or Teal. Use one set only (Lucide or Phosphor, free).
- **Illustration:** minimal. Where needed, use flat navy and teal shapes that echo the swoosh curve.

---

## Part 3 · Verbal identity
Full detail is in `brand/voice.md`. Essentials:

- **Voice essence:** Cura sounds like a caring, steady local driver who shows up on time: warm, clear and trustworthy.
- **Tone:** warm-professional, calm, accessible, respectful.
- **Qualities:** reassuring, respectful, plain-spoken, honest, dependable, warm.
- **Style:** short sentences (most under 20 words). Contractions yes. Active voice. **No em dashes.** No exclamation marks in headlines. Sentence case. Numerals for times, prices and phone numbers. Grade 6–8 reading level.
- **We say:** ride, rider, driver, on time, door-to-door, appointment, pickup, loved one, family, safe, dignity, peace of mind, book, call us.
- **We don't say:** solutions, premier, luxury, world-class, #1, the elderly, wheelchair-bound, handicapped, guarantee, statewide ⏳, licensed ⏳, Medicaid provider ⏳, years of experience.

---

## Part 4 · Messaging (draft ⏳, finalize with brand-messaging and client input)

- **Core message:** Safe, on-time rides to medical appointments, with the care you'd give your own family.
- **Value proposition:** Cura Mobility Services drives Baton Rouge-area riders to doctor visits, dialysis, treatments and hospital discharges. We come to the door, help riders in and out, and get them there on time. We explain costs and payment options up front.
- **Tagline options** (none approved yet; full framework in `brand/messaging.md`):
  1. **"Cura means care."** (recommended: "cura" is Latin for care, so it's unique to the name)
  2. "On time. On your side." (secondary line for ads and booking)
  3. "Rides with care." (van graphics)
  4. "Getting you there, like family."
  5. "Safe rides. Kind hands."
- **Key messages** (each backed by a real operating behavior before publishing):
  1. **We show up.** Day-before confirmation and a call when we're on the way. ⏳ Confirm the process.
  2. **We help door to door.** Assistance from the front door to the clinic check-in.
  3. **We make it simple.** One local number, easy booking, clear prices. ⏳ Pricing model.
  4. **We're local.** A Baton Rouge company serving [confirmed parishes] ⏳.

---

## Part 5 · Brand in use

### Website (turnkey WordPress)
- **Header:** horizontal logo on white; a Navy "Book a ride" button; an outlined phone button showing (225) 363-0845 ⏳. On mobile, a sticky bottom bar with Call and Book.
- **Hero:** navy or white with a real photo, an H1 with "Baton Rouge", a one-line promise, then the Book and Call buttons, then a trust strip that uses only verified facts.
- **CTA blocks:** follow the BlakSheep CTA standard. The phone is a real button (secondary and outlined), both buttons are equal width, stacked in a column up to about 520 px. CSS prefix `cura-`.
- **Sections:** alternate White and Mist backgrounds. Use Teal Tint for FAQ and "who pays" callouts.
- **Forms:** large 18 px inputs, visible labels, 44 px minimum tap targets, and a plain-language confirmation message.

### Google Business Profile and social
- **Avatar:** the shield mark on white. **Cover:** a real van photo ⏳.
- **Posts:** a calm, community tone. Share rider stories only with written permission. Never use health details.

### Email and texts
- Plain text, with a signature of name, "Cura Mobility Services", phone and website. Keep messages logistical and short (see the channel table in voice.md).

### Print and vehicle
- **Business card:** logo front on white. The back is navy with a white reversed logo, name, phone, website, and a QR code linking to the Google review page.
- **Van graphics:** navy and white, with the phone number large and legible from 50 ft. Needs vector artwork (redraw) before production. Show no "licensed" or "Medicaid" language until verified.
- **Review QR card:** a 4×6 card for riders with "How was your ride?" and a QR code to leave a Google review.

### Brand don'ts checklist
- [ ] Never use the stacked logo below 120 px. Switch to the mark or horizontal version.
- [ ] Never set small text in Cura Teal `#058D8D`. Use Teal Deep `#047878`.
- [ ] Never use colors outside this palette, or gradients in UI.
- [ ] Never use fonts other than Montserrat and Atkinson Hyperlegible (plus the fallbacks).
- [ ] Never use body text below 16 px.
- [ ] Never claim licensed, Medicaid provider, statewide, tenure, ride counts or ratings until verified.
- [ ] Never show ambulances, emergency imagery or stretchers.
- [ ] Never use em dashes, hype words or pressure tactics.
- [ ] Never share rider photos or stories without written consent.

---

## Part 6 · Contacts and assets
- **Brand guardian:** Michael Veal (owner) after handoff. BlakSheep Creative during the build.
- **Assets:** repo `brand/assets/`, mirrored to pCloud `Clients/Cura Mobility Services/01-Brand-Assets/`.
- **Questions:** Clint Sanchez, BlakSheep Creative, clint@clintsanchez.com.
