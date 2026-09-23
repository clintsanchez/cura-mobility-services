# BlakSheep Content Engine — how posts are written, structured & illustrated

*Studied 2026-06-09 from `clintsanchez/blaksheep-creative-content-generation-engine` (the agency monorepo, ~20 clients). This is the established BSC method. Tiger Town blog content should match it. Source of truth for the conventions: `_blaksheep-conventions/CLAUDE.md` in that repo.*

## The toolchain (what every BSC client uses)
- **wp-blog-publisher** (`clintsanchez/wp-blog-publisher`) — Python CLI: markdown+frontmatter → WP REST. Wraps every top-level element in Gutenberg `wp:*` blocks, renders fenced divs, uploads featured image, sets SEOPress meta, writes FAQ schema sidecar.
- **SEOPress** (free+Pro) for SEO + social meta. **WP Engine + Cloudflare** hosting (needs real Chrome UA + 5–8s cooldown on scripted REST or you get Cloudflare 1010/403).
- TT's stack matches (WP Engine, SEOPress, WP REST) — but TT uses **Elementor**, not Breakdance. Posts are standard WP posts, fully REST-writable (the bridge we built already does this via Novamira).

## Post structure (mandatory opening sequence — every post)
1. **H1** with primary keyword
2. **H2 directly under H1** (keyword-rich)
3. **Quick Answer** paragraph (40–75 words) under the first H2 — `:::quick-answer`
4. **TLDR block** — 5–7 bullets, acts as table of contents — `:::tldr`
5. **Local Hook** paragraph (geography + audience friction)
6. Body H2s (every 200–300 words) following the **section sandwich**
7. **FAQ** with a *topical* H2 (never "Frequently Asked Questions") + lede paragraph, 5–7 Q&As @ 40–60 words
8. **Closing CTA** — `:::cta` with a bare-link button line

**Section sandwich (every section):** heading → 1–3 sentence hook/lede → main content → transition sentence. When a section has a table: hook above, one-sentence interpretation below.

**Sandwich (page-level):** 40–75 word direct answer → detail + tables + citations → brand credibility + specific next step.

## Hard style rules (the "content engine style rules")
- **NO em dashes (—). EVER.** Period + new sentence, comma, colon, or parens. (TT's BRAND.md already bans them.)
- **Banned words:** ensure, crucial, vital, nestled, uncover, journey, embark, unleash, dive, world, delve, discover, plethora, whether, indulge, unlock, unveil, look no further, realm, elevate, landscape, navigate, daunting, tapestry, unique blend, enhancing, game changer, stand out, stark, contrast. **Grep before publishing.**
- **Paragraphs ≤ 4 lines.** Short sentences, active voice, no hype/filler/generic openers.
- **No back-to-back headings** — every heading gets a hook paragraph.
- **3 CTA modules** per post: above-the-fold, mid-page, end. Plus inline micro-CTAs (`[call or text <number>](tel:...)`).
- **3–6 internal links**, varied anchors (no exact-match repeats, no "click here"/"learn more", no meta anchors like "the service page").
- **No invented stats.** Cite a real source (woven into prose — NOT a `(Source, Year)` parenthetical; the year goes in the prose) or remove the number. No sources-list dump at the bottom.
- **External links** open new tab: raw HTML `<a href target="_blank" rel="noopener noreferrer">`. Internal/tel/mailto stay same-tab markdown.
- **Phone anchors** → `tel:+1XXXXXXXXXX` (10 digits, no formatting). For TT: `tel:+15042106398`.

## Fenced divs the publisher renders (with the client CSS prefix)
`:::quick-answer` · `:::tldr` · `:::related` (one block, near end) · `:::cta` (button needs a bare `[Label](url)` line) · `:::tip`. Markdown tables auto-wrap in `<prefix>-table`. **TT note:** our posts render through the Elementor Single Post template (2464), not a Breakdance/prefix-CSS theme — so we either (a) define matching `ttc-` block CSS, or (b) style these inline. Already using `ttc-summary`/`ttc-cta` classes in the first TT draft.

## Frontmatter spec (canonical keys — wrong keys are silently dropped)
`title, slug, primary_category, categories[], tags[], author (WP user ID), featured_image (path, not URL), faq_schema: sidecar, excerpt, seo_title, seo_description, target_keyword, social_fb_title, social_fb_desc, social_twitter_title, social_twitter_desc, status, wp_post_id (auto)`. **Banned legacy keys:** `meta_title`→`seo_title`, `meta_description`→`seo_description`, `target_kw`→`target_keyword`. (Our Novamira bridge already maps to the same SEOPress meta keys: `_seopress_titles_title/_desc`, `_seopress_analysis_target_kw`, `_seopress_social_fb_*`.)

## Images — strict sourcing order (stock is LAST resort)
1. WP media library (`?search=<slug>`) 2. Local client-owned Photos/Graphics 3. Client hosted URLs 4. **Custom HTML→WebP** (author from the client's graphic vault, render via Chrome headless) 5. Stock (Pixabay→Unsplash→Pexels) **only if nothing else.** *Stock dilutes local-operator positioning.* For TT: lead with the 17 real project photos.

## Charts / graphics / featured images — how they're MADE
**Not a charting library. Branded HTML rendered to images via Chrome headless + Pillow→WebP.** Three asset types:
1. **Featured image** — `scripts/generate-featured-image.py` per client. Renders a parameterized HTML template (`templates/featured-images/blog-featured-template.html`) at **1080×608 WebP**. Two-panel layout: text panel (eyebrow tag, Oswald headline with `.highlight` accent span, sub-deck) + photo panel with scrim, brand accent bar, logo, trust badge. Flags: `--category --title (raw HTML) --sub-deck --image-url --image-alt --upload-to-wp`.
2. **Social cards** — `scripts/generate-cards.py`, **1080×1080**, modes: text (rotating styles A–D), hero (photo + wash), graphic (cost/timeline infographic), photo. Drives off `social/posts.json`.
3. **Inline data graphics** — authored as **inline `<svg>`** in the post body (sharp, accessible, zero network), then `_blaksheep-conventions/scripts/svg-to-webp.py` renders each SVG → WebP media-library backstop (for Pinterest/social/email reuse). Charts seen: horizontal/grouped bar, donut, timeline, stat cards, comparison tables. Source patterns live in each client's **"mega-graphic template vault"** HTML (`briefs/_client-source-docs/<client>-mega-graphic-template-vault.html`) — packs for YouTube, social/blog, reviews, infographic/process, brand/team. **Real-data tables are also common in place of charts** (the Starling bathroom post uses tables, 0 SVGs).

All graphic templates use the client's **brand colors + fonts + logo**. Fonts preloaded in svg-to-webp: Montserrat, Poppins, Plus Jakarta Sans, Public Sans (add per client).

## The 3-phase publish workflow (human gate between draft & publish)
- **Phase A (one turn):** brief → write → self-audit (em dash/banned words/structure) → generate featured image → push as **DRAFT** → PATCH author + SEOPress social → author inbound-link plan (don't run) → FAQ schema sidecar → review HTML doc → hand off. **STOP — do not auto-publish.**
- **Phase B (user says "publish"):** re-fetch body → flip to publish → verify 200 → paste FAQ schema manually → distribute social via OnlySocial (`os_publish.py`) → request GSC indexing (`gsc.py index`) → client notification email.
- **Phase C (user says "do inbound linking"):** insert one `<prefix>-related` block before each source post's last CTA, linking to the new post (cooldowns between calls).

## Known tool gaps (every client hits these)
- FAQ schema `schemas-manual` PUT silently drops → **manual paste** the sidecar into SEOPress.
- Featured-image auto-upload sometimes returns `featured_media: 0` → verify + manual PATCH.
- SEOPress has **no category/taxonomy REST endpoints** → category SEO meta is manual in wp-admin.
- Cloudflare 1010/403 on scripted REST → real Chrome UA + 5–8s cooldown.

## How TT's setup compares (gaps to close to match BSC)
| BSC convention | TT status |
|---|---|
| Post structure (Quick Answer/TLDR/Local Hook/topical FAQ/3 CTAs) | First draft (post 2470) has summary+FAQ+CTA but NOT the full BSC sequence — **align next** |
| No em dash / banned words / ≤4-line paras | BRAND.md bans em dash; should add the **full banned-word grep** to pre-publish |
| Frontmatter + SEOPress keys | Novamira bridge sets the same SEOPress keys ✓ (no markdown frontmatter; we set meta directly) |
| Featured image (branded 1080×608 template) | **Not built for TT yet** — we used a real photo as featured image. Could build a TT featured-image template (purple #401F78 / gold #F9C94B, fonts, logo) |
| Inline SVG charts + svg-to-webp | **Not used yet** — option when a post has comparable data |
| Social cards + OnlySocial + GSC + notify email | **Not wired for TT** — future |
| 3-phase draft→review→publish gate | Our flow already drafts-only + waits for approval ✓ |

**Bottom line:** TT's pipeline (claude-blog + Novamira WP bridge) can produce BSC-compliant posts, but to truly match we should: (1) enforce the full BSC post structure + banned-word grep in BRAND.md/the write step, (2) optionally build a TT-branded featured-image template + the SVG chart pattern, (3) add the `ttc-` block CSS (or inline styling) for quick-answer/tldr/cta/related/table.

## TT production rules — locked in 2026-06-09 (apply to every TT post)
These refine the structure above for TT's Elementor Single Post template (2464):

1. **NO leading featured image in post content.** The template has a standalone post-featured-image module (`bmainfi`) before the body. Set the featured image via `set_post_thumbnail()` only; do **not** repeat it as the first in-content `<figure>`. (We strip any leading `<figure><img></figure>`.)
2. **First H2 must be a real subheading, not a title restatement.** The H1 lives in the hero. So the old BSC "H2 directly under H1 = keyword restatement of the title" does NOT apply on TT. Drop/rewrite any first H2 that duplicates the title (fuzzy match ≥70%, but also catch near-duplicates by hand). Content opens with the Quick Answer box, then the first *real* topical H2.
3. **Gutenberg blocks, always.** Convert raw HTML → native blocks: `wp:heading` (h2/h3), `wp:paragraph`, `wp:list`. Wrap every custom/branded element (`tt-quick-answer`, `tt-tldr`, `tt-related`, `tt-cta`, `tt-table`, and **inline `<svg>` charts**) in a **`wp:html` Custom HTML block** — that preserves classes and inline SVG. Per-post converter lives in chat history (DOMDocument walk; skips XML comment nodes so it is idempotent on already-Gutenberg input).
4. **FAQ schema → SEOPress manual, with script tag.** Store a `FAQPage` `<script type="application/ld+json">…</script>` in post meta `_seopress_pro_schemas_manual` as `[[ '_seopress_pro_rich_snippets_type'=>'custom', '_seopress_pro_rich_snippets_custom'=>$scriptTag, ...11 article_* keys empty ]]`. **This DOES work via direct meta write on TT** (contradicts BSC gap "schemas-manual PUT silently drops" — that was the REST PUT; the serialized-meta write succeeds, FAQPage verified emitting live). Build the FAQ array from the post's FAQ `<h3>` + following `<p>`.
5. **Tags = 3-5 shared topical buckets, Title Case.** Derived from H2s/topic, overlapping across posts so they cluster. Current bucket vocabulary: `Screen Rooms`, `Patio Covers`, `Sunrooms`, `Glass Rooms`, `Cost Guide`, `Outdoor Living`, `Baton Rouge`. Set via `wp_set_post_terms($id,$names,'post_tag',false)` (names preserve casing).

Applied to posts 2470, 2495, 2497 on 2026-06-09 (all verified live: FAQPage in ld+json, SVG charts intact as Custom HTML blocks, no leading in-content image, first H2 is a subheading).
