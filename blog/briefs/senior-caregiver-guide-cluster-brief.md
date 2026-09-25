# Content brief: Senior and caregiver guide (hub + 2 spokes)

> **Client:** Cura Mobility Services · **Brief written:** 2026-09-24 · **Pillar:** Senior and caregiver guide
> **Category:** Caregiver guides (term 40, slug `caregiver-guides`) · **Author:** WP user **2** (Cura Mobility Services)
> **Permalinks:** `/%category%/%postname%/` → `/caregiver-guides/<slug>/`
> **Stats:** only from `briefs/research-stats.md` (verified). Anything marked UNVERIFIED stays out.
> **Keyword data:** none. SE Ranking credits are out (see memory); targets are chosen by intent, not volume.

## Reader

Adult children and family caregivers (typically 40–65) arranging rides for a parent who no longer drives.
They are worried, short on time, and often booking for someone else. Plain English, short sentences,
warm and practical (brand voice: Professional, Empathetic / Warm, Friendly / Approachable).

## Cluster map

| Role | Working title | Slug | Primary keyword (intent) |
|---|---|---|---|
| Hub | A caregiver's guide to medical rides for aging parents in Baton Rouge | `medical-rides-for-aging-parents-baton-rouge` | medical transportation for elderly parents (informational → commercial) |
| Spoke | Hospital discharge: how to plan the ride home for a parent | `planning-ride-home-hospital-discharge` | ride home from hospital after discharge (informational) |
| Spoke | Helping a parent who uses a wheelchair or walker get to appointments | `wheelchair-walker-parent-appointments` | helping elderly parent with walker get to appointments (informational) |

Hub links down to both spokes; each spoke links up to the hub and across to the other spoke.

## ⚠️ Cannibalization guards (live pages, probed 2026-09-24)

| Live page | Owns | Blog posts must NOT |
|---|---|---|
| `/services/hospital-discharge-rides/` | "hospital discharge transportation Baton Rouge" (commercial) + FAQs: settle at home, which hospitals, pharmacy stop, family booking, time changes | Re-answer those five FAQs or target the commercial phrase. The spoke owns **planning** (what to ask before discharge day, what to bring, the first 24 hours). Link to the service page as the money page. |
| `/services/wheelchair-transportation/` | "wheelchair transportation Baton Rouge" + FAQs: cost, walker/scooter, caregiver along, transfers, own chair | Promise vehicle equipment (lifts, ramps, securement are **unconfirmed**) or restate the FAQs. The spoke owns **caregiver prep**: getting the parent ready, the car transfer, what to pack, the appointment itself. |
| `/services/senior-and-everyday-rides/`, `/services/recurring-rides/`, `/services/doctor-appointment-rides/` | Commercial ride types | Target "senior transportation Baton Rouge". The hub is a caregiver's decision guide and links to these. |
| `/faqs/` | General booking FAQs | Copy FAQ wording. Blog FAQ blocks use new, topical questions. |

## Accuracy guardrails (CLAUDE.md + standing rules)

- No "licensed", "Medicaid provider", "certified", "statewide", years-in-business or street-address claims.
- Cura does **not** claim to bill Medicaid. Medicaid NEMT is described as a public benefit with its own booking line, with no claim that Cura is part of it.
- No wheelchair-van, lift, ramp or securement claims. Safe phrasing: "help for riders who use a wheelchair, walker or scooter; tell us your mobility needs when you book."
- Call-only: no texting. Phone (225) 363-0845, `tel:+12253630845`.
- No reviews or testimonials in the posts (the reviews on the site are sample placeholders).
- Medical guidance is general; send readers to the care team for their parent's specifics. For an emergency, call 911.

## Structure (engine standard)

H1 · keyword H2 · `:::quick-answer` (40–75 words) · `:::tldr` (5–7 bullets) · local hook · sandwich sections
(heading every 200–300 words, hook after every heading, paragraphs ≤ 4 lines) · 1–2 inline branded SVG
figures · topical FAQ H2 + lede + 5–7 Q&As (40–60 words) · `:::related` (live URLs only) · 3 `:::cta`
blocks (above the fold, mid-page, end): `[Call (225) 363-0845](tel:+12253630845)` + a form page.

**CTA form pages:** hub → `/book-a-ride/`; discharge spoke → `/forms/quote/`; mobility spoke → `/forms/consultation/`.

## Word counts

Hub 1,700–2,000 · spokes 1,300–1,600 each.

## Images

Featured (1080×608, `scripts/generate-featured-image.py`), from the Cura media library:
- Hub: `daughter-and-senior-mother-looking-at-phone.webp`
- Discharge: `woman-with-man-in-wheelchair-ready-to-leave-hospital-room.webp`
- Mobility: `caregiver-helping-senior-woman-with-walker-at-home.webp`
No van-lift or ramp photos.
