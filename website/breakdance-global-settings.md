# Breakdance Global Settings: Cura design kit

*2026-09-23. Apply in **Breakdance → Global Settings** right after importing the **Cab Service Layouts Pack** (Pixels Library Plus). Values come from `brand-style-guide.md` / `css-tokens.css`; keep all three in sync.*

## How the pack is themed (verified from `cabservices.json`)
The pack's look is driven by only **6 palette colors, 2 fonts, the H2 size and 1 button style**, and its elements reference the palette as CSS variables. Changing these values re-themes every imported page at once. **Change the values, not the labels or variable names**, so the imported sections stay linked.

## 1. Colors (Global Settings → Colors → Palette)

| Pack slot (label) | Pack value | → Cura value | Cura token | Notes |
|---|---|---|---|---|
| `bdp-primary` | `#fdb813` (taxi yellow) | **`#02265A`** | Cura Navy | Primary buttons, accents, icons. White text on it (14.7:1). |
| `bdp-secondary` | `#2a2a2a` | **`#047878`** | Teal Deep | Button hover and dark cards. White text on it (5.3:1). |
| `bdp-heading` | `#000000` | **`#02265A`** | Cura Navy | All headings |
| `bdp-text` | `#666` | **`#1A2433`** | Ink | Body text. Darker than the pack for older readers (15.6:1). |
| `bdp-light` | `#F7F7F7` | **`#F3F6F9`** | Mist | Light section backgrounds |
| `bdp-shedow` *(sic)* | `#00000012` | **`#02265A14`** | navy at 8% | Card shadows |

Also set: **Headings color** `#02265A`, **Text color** `#1A2433`. Add two extra palette colors (new slots, safe to add): **Cura Teal `#058D8D`** (icons and large display only, never small text) and **Teal Tint `#E6F4F4`** (FAQ and "who pays" callouts).

Check after the swap: any leftover yellow-specific element (for example yellow icon circles with dark icons) now shows a navy fill. Make its icon white, or switch the fill to Teal Tint with a navy icon.

## 2. Typography (Global Settings → Typography)
| Setting | Pack | → Cura |
|---|---|---|
| Heading font | Poppins | **Montserrat** (Google). Weights 600, 700 |
| Body font | Poppins | **Atkinson Hyperlegible** (Google). Weights 400, 700 |
| Body size | default | **18px** (never below 16px); line height 1.6 |
| H1 | default | 44 / 40 / 36 / 34 / 32 px (desktop → phone), weight 700, line height 1.15 |
| H2 | 45 / 40 / 36 / 34 / 30 px, weight 600, line height 1.1 | **34 / 32 / 30 / 28 / 26 px**, weight 700, line height 1.2 |
| H3 | default | 24 / 22 / 22 / 20 / 20 px, weight 600 |
| Eyebrow / small labels | per section | Montserrat 600, 13px, uppercase, letter-spacing 0.08em |

Self-host the fonts if Breakdance offers it (Settings → Performance / Fonts). Otherwise use Google Fonts with `display=swap`.

## 3. Buttons (Global Settings → Buttons)
| | Pack | → Cura |
|---|---|---|
| Primary background | var(bdp-primary) | unchanged (now navy) |
| Primary hover | var(bdp-secondary) | unchanged (now Teal Deep) |
| Text color | pack default | **#FFFFFF** |
| Corner radius | 10px | **10px** (keep) |
| Font | 16px / 500 | **17px / 600 Montserrat**, sentence case |
| Min height / padding | pack default | **≥ 48px tall**, 14px 28px padding (44px min tap target) |
| **Secondary (phone) button** | not defined | **Outlined**: transparent background, 2px border and text in Navy. Hover fills Navy with white text. On navy bands: white border and text, hover fills white with navy text. |

**BlakSheep CTA standard** (from CLAUDE.md, apply to every CTA pair):
1. The phone is a real **button**, not a text link.
2. The phone is the **secondary** (outlined) action. "Book a ride" is the primary (solid).
3. **Equal widths**: stack the buttons in a column, stretch them, and cap the group at 520px.

## 4. Containers and spacing
- Section max width **1200px**; side padding 20px on mobile.
- Section vertical padding **96px** desktop, **64px** tablet, **48px** phone.
- Card radius **12px**, border `rgba(2,38,90,0.12)`, shadow palette `bdp-shedow`.

## 5. Site identity (WordPress + Breakdance header/footer)
- **Header logo:** `brand/assets/svg/cura-logo-horizontal.svg` at about 220px wide desktop and 170px mobile. On navy headers use `cura-logo-horizontal-on-navy.svg`.
- **Footer logo:** `cura-logo-stacked-on-navy.svg` on a navy footer.
- **Site Icon** (Settings → General): `brand/assets/png/site-icon-512.png`.
- **Header right side:** outlined phone button (225) 363-0845 ⏳ and a solid "Book a ride" button. On mobile, a sticky bottom bar with Call and Book.
- **Footer line:** "For medical emergencies, call 911."

## 6. Pack clean-up checklist (every import)
- [ ] Delete all "1356+ happy customers" / "20+ years" / "Since 1992" stat blocks and fake testimonials (guardrail: no invented numbers or tenure).
- [ ] Replace every demo image. Upload any kept image to the Media Library; never keep hotlinks to `bdlayoutspack.com` / `bdtemplatehub.com`.
- [ ] Remove "Pixels Builder" logos, lorem ipsum and demo addresses/phones.
- [ ] Taxi wording → ride / van / appointment language (see `brand/voice.md`).
- [ ] Remove "Buy this template" / "Made with Breakdance" demo widgets if any came through.

## 7. Second pack (Senior Care v2): import notes
The Senior Care pack has **its own palette with different variable IDs**. Importing its global settings would **overwrite** the Cab Service palette above. So:
- Import the **Cab Service pack with global settings** (this becomes the base).
- Import **Senior Care v2 pages/sections only**, without its global settings. Then re-point any colors in the sections you keep to the Cura palette slots above (inspect its `.json` when downloaded to map its slots the same way).
