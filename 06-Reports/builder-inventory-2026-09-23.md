# Builder, license and template inventory (for the Cura stack decision)

*2026-09-23. Read-only sweep of local files, LocalWP site databases, other client repos and memory notes. No license keys are recorded here. Gmail receipts were not checked.*

## Summary

| Builder | License evidence | Relevant templates on hand | BSC history |
|---|---|---|---|
| Elementor Pro | Active, recurring, expires 2027-07-18 (Red White and Clix DB). Plan and site count unknown. | No medical/NEMT kit. Envato kits on disk: construction, waste, landscaping, golf, gaming. | 2026 fallback after rejected Bricks builds (Tiger Town, LA Septic Suckers, Divine Cleaning, Metal Man). Demo-content leftovers every time. |
| Bricks | Theme license term unknown. **BricksPlus Full Access: lifetime, unlimited sites; templates are JSON with no key, so they survive a lapse.** Bricks Awesome access pass (Duogeeks invoice $750). | BricksPlus / Bricks Awesome online libraries (not yet browsed for medical/transport). Local: Kira v1.0, Ecoboundry, ACSS packs. | The most-used stack (~15 clients). Tiger Town Bricks rejected; Tru-Tex rebuilt on the SolarX BricksPlus template. |
| Etch + ACSS | "Valid" on SDM, Load & Geaux, TCMHA. Term unknown. | BSC Etch blueprint and build kit; Translo (transport, React) ported on Load & Geaux. | Newest builds: SDM, SBG, Klutter Krewe. |
| Breakdance | No current license; zips 1.0.3 and 2.0.0 only. | **Pixels Library Plus: senior-care, medical, cab/transport layouts (only on-disk match).** | Legacy: Magnolia, Karport, Starling, Mayeux. |
| Gutenberg (block theme) | No license needed. | None. | Unused. |
| Divi / Oxygen / Astra / Kadence Pro | Legacy, or nulled/unofficial copies. **Do not use.** | Divi layouts, no medical. | Legacy. |

## Handoff risk (from BSC history)
- On client churn, BSC cancels the subscriptions it pays for. There's no documented license-transfer process.
- Magnolia: unlicensed WooCommerce add-ons with no updater broke checkout after a WooCommerce update and the PHP 8.4 move.
- SDM: Novamira Pro was unlicensed and will never update; 8 of 17 plugin updaters returned nothing.
- Kits leave demo content and hotlinked demo images (themex.io, brickslayoutspack.com). Always localize images and purge the demo.

## Ranking for a turnkey handoff (pending: is the Bricks license lifetime + unlimited?)
1. Bricks + a BricksPlus template, if the Bricks license is lifetime. Minimal plugins (free SEO, free forms). Weakness: harder for the owner to edit.
2. Gutenberg + a free block theme. Zero licenses, easiest to edit, but no templates on hand.
3. Elementor Pro + a purchased medical kit. The client buys his own Pro license (about $60/yr), or it lapses.
4. Etch. Unknown license term, newer builder.
5. Breakdance. Best-matching layouts, but needs a new license.

Sources: agent sweeps of `~/Local Sites`, pCloud `Website Development/Frequently Used WP Items`, `~/Downloads`, client repos under `~/Documents/Claude/`, and memory notes in the BlakSheep Content Generation Engine project (reference-bricksplus-themex-license.md, reference-magnolia-wpe-plugin-fix-php8.md, reference_client_churn_teardown.md).
