# Cura Mobility Services — Design System (DESIGN.md)

> **Feeds Stitch / Claude Design** (`create_design_system_from_design_md`).
> The client described their colors in words below — **sample the exact hex from
> the uploaded logo in `brand/`** and replace the `#______` placeholders. Keep
> values identical to `website/css-tokens.css` and `brand-style-guide.md`.

## Brand
- **Name:** Cura Mobility Services
- **Contact:** Michael Veal — mveal72@yahoo.com — +12253630845
- **What they do:** Non-emergency medical rides by van, Baton Rouge area (see `brand/context.md`)
- **Differentiator (working):** reliability and dignity: on time, door-to-door, a local owner, clear prices
- **Audience:** family caregivers booking for a loved one; seniors, dialysis and post-discharge riders
- **Voice:** Professional, Empathetic / Warm, Friendly / Approachable

## Color Palette
*(Client gave no color names. Hex sampled from the survey logo JPG (raster); confirm against vector files when received.)*

| Role | Token | Value |
|---|---|---|
| Primary | `primary` | `#02265A` (Cura Navy) |
| Secondary | `secondary` | `#058D8D` (Cura Teal; large type/graphics only, 4.04:1) |
| Accent | `accent` | `#047878` (Teal Deep, text-safe, 5.30:1) |
| Tint | `tint` | `#E6F4F4` (Teal Tint, callouts) |
| Background | `background` | `#FFFFFF` |
| Surface | `surface` | `#F3F6F9` (Mist) |
| Text | `text` | `#1A2433` |
| Text muted | `text-muted` | `#5A6675` |
| Success | `success` | `#22A06B` |
| Warning | `warning` | `#E8A33D` |
| Error | `error` | `#D9534F` |

## Typography
- **Display font:** Montserrat 600/700 (matches the logo's geometric tagline; client to confirm)
- **Body font:** Atkinson Hyperlegible 400/700 (built for low-vision readability; client to confirm)
- **Scale:** display clamp→3.5rem · h1 2.75rem · h2 2.125rem · h3 1.5rem · body 1.125rem (never < 1rem) · eyebrow 0.8125rem uppercase +0.08em
- **Line height:** body 1.6, headings 1.15

## Spacing & Layout
- **Scale (px):** 8 · 16 · 32 · 64 · 96 · 128
- **Container:** 1200px · **Radius (px):** 6 / 12 / 20

## Components
- **Button:** primary (filled), outline, large. 44px min tap target.
- **Card:** media + body, 12px radius, subtle border.
- **Section:** standard + surface variant; eyebrow + heading + lead.
- **Hero:** headline + subhead + primary CTA + trust strip.
- **Header / footer:** logo lockup, nav, click-to-call CTA.

## Voice in UI copy
Brand should sound: Professional, Empathetic / Warm, Friendly / Approachable.

## Conversion model
The primary CTA is "Book a ride" (a request form that emails the owner; turnkey, no CRM). The secondary CTA is an outlined phone button. Pricing is TBD (possibly private-pay with a Stripe payment link). The CTA standard: the phone is a real button, both buttons are equal width, stacked in a column up to 520px. On mobile, a sticky Call + Book bar.

## Imagery
Real, warm photos of the van, driver and door-to-door help. No ambulances, emergency lights or stretchers. Line icons, 2px, navy or teal.
