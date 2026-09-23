# Cura Mobility Services — Project Instructions for Claude Code

This is the working repo for **Cura Mobility Services**, a BlakSheep Creative client. Build
their website and marketing collateral here. Onboarded 2026-09-22 from the GHL
BSC Onboarding Survey.

## Who this is
- **Contact:** Michael Veal · +12253630845 · mveal72@yahoo.com
- **Website:** _not provided_ · **Facebook:** _not captured_
- **What they do:** _not captured_
- **Differentiator (lead with this):** _not captured_
- **GHL contact (source of truth):** `8OcXVaFmoaaMc5LfpNy6`

## Source of truth
Read these first; keep them current as the engagement evolves:
- `.agents/product-marketing.md` — positioning, ICP, voice. **The canonical doc.**
- `00-Client-Brief.md` — full intake brief.
- `HANDOFF.md` — current status + open confirmations. **Read when resuming.**
- `aib/` — Agency-in-a-BOX client files (also synced to the AiB vault).

## Brand
- **Colors (client-described):** primary _not captured_, secondary _not captured_, accent _not captured_ — **sample exact hex from the logo in `brand/` before using.**
- **Voice:** Professional, Empathetic / Warm, Friendly / Approachable
- **Do NOT mention:** _not captured_
- Design system spec: `DESIGN.md` (Stitch) · tokens: `website/css-tokens.css` · guide: `brand-style-guide.md`. Keep all three in lockstep.
- **For brand work, use the `brand-guidelines` skill** — sample hex from the logo
  in `brand/`, then run it to produce the full brand guideline (accessibility-
  checked colors, type hierarchy, logo rules, voice samples, compliance
  checklist). Write its output to `brand-style-guide.md`; keep `DESIGN.md` +
  `css-tokens.css` in sync with its palette.

## APIs / connections
- **WordPress:** fill `.env` from `.env.example`; client helpers in `tools/wp/` (`python3 tools/wp/wp.py ping` to test). WP MCP block in `.mcp.json`.
- **GHL:** this client's contact id is in `.env` (`GHL_CONTACT_ID`); shared PIT/location creds live in the ghl-toolkit `.env`.
- **Credentials:** hosting/domain logins from onboarding are in `CREDENTIALS.local.md` (gitignored, 0600). **Move them to a password manager and delete the file.**

## 🚨 Accuracy guardrail (do not skip)
Before publishing ANY public claim, verify against authoritative records (see
`06-Reports/records-check.md`): license status/class, years in business
(Less than 1 year), and registered address vs. service area. Never fabricate
reviews, credentials, or experience claims. Safe fallback for unconfirmed
numbers: "decades of combined experience."

## 🚨 Blog CTA standard — set this up BEFORE the first post

Every BlakSheep client has needed the same three CTA fixes, and we keep finding
them one post at a time. Do all three when the CSS prefix is first defined:

1. **The phone is a BUTTON, not a link.** `wp_publish.py` emits the first
   `:::cta` link as a bare paragraph above the buttons group. Promote it, and
   re-check after every publisher run (re-publishing reverts it).
2. **The phone is the SECONDARY action** — outlined, conversion button stays
   solid. Ring colour chosen for contrast against the CTA background.
3. **Both buttons are EQUAL WIDTH** — column + stretch, capped ~520px.

Full CSS, detection queries, and the WPCodeBox gotchas:
**`docs/blog-cta-standard.md`** in the bsc-onboarding repo. Metal Man needed 15
published CTAs rewritten because this was skipped at setup.

## Next steps
1. Move credentials to a password manager; delete `CREDENTIALS.local.md`.
2. Collect/sample brand assets → fill `DESIGN.md` / `css-tokens.css` / `brand-style-guide.md`.
3. Run the public-records check.
4. Create the design system in Stitch from `DESIGN.md`.
5. SEO suite → homepage → priority pages.
6. **Apply the blog CTA standard above** when the CSS prefix is set, before post one.
