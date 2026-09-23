# Bricks Builder — API & Programmatic Build Notes

*How to build the Tiger Town Bricks site (`tiger-town-construction-bricks.local`) programmatically. Verified against the live install: Bricks theme **v2.3.6**, active with child theme `blaksheep-creative-bricks-child-v2.1`. Sources: official Bricks Academy docs + the theme source on disk.*

## TL;DR — the one thing that shapes everything
**Bricks has NO REST endpoint for *writing* page content.** Its `bricks/v1` REST API is render/read-only. Page layouts are stored as a **serialized PHP array of "elements"** in post meta. So to build pages from code you either:
1. **Write the element array into post meta directly** (DB / WP PHP) — fastest for bulk, what we'll use, or
2. **Import a Bricks template JSON** via the Templates UI (or programmatically as posts), or
3. Build in the **builder UI** (which saves via internal admin-ajax `bricks_save_post`).

There is no `/wp-json` route to POST a page design. Core WP REST (`/wp/v2/pages`) still works for the post itself (title/slug/status), media, menus, options, SEO meta — just not the Bricks layout.

---

## Where Bricks stores everything (verified meta keys & options)

Defined in `themes/bricks/includes/functions.php`:

| Constant | Key | Holds |
|---|---|---|
| `BRICKS_DB_PAGE_CONTENT` | `_bricks_page_content_2` | **Page/post/template body** — the element array (LONGTEXT) |
| `BRICKS_DB_PAGE_HEADER` | `_bricks_page_header_2` | Header element array (when set per-post) |
| `BRICKS_DB_PAGE_FOOTER` | `_bricks_page_footer_2` | Footer element array |
| `BRICKS_DB_EDITOR_MODE` | `_bricks_editor_mode` | `bricks` vs `wordpress` — set to `bricks` so Bricks renders the page |
| `BRICKS_DB_TEMPLATE_TYPE` | `_bricks_template_type` | For `bricks_template` posts: `header`/`footer`/`content`/`archive`/`search`/`error`/`popup`/`section` |
| `BRICKS_DB_TEMPLATE_SETTINGS` | `_bricks_template_settings` | Template conditions (where it applies) |
| `BRICKS_DB_GLOBAL_SETTINGS` | `bricks_global_settings` (option) | Theme styles, colors, breakpoints, builder settings |
| `BRICKS_DB_GLOBAL_ELEMENTS` | `bricks_global_elements` (option) | Global/reusable elements |

- Templates (headers/footers/popups/etc.) are posts of type **`bricks_template`**, distinguished by the `_bricks_template_type` meta value.
- `get_post_meta($id, '_bricks_page_content_2', true)` returns the element array; `update_post_meta(...)` writes it. (Stored serialized; if writing raw SQL you must serialize + `wp_slash`.)
- **CRITICAL:** when you set `_bricks_page_content_2`, also set `_bricks_editor_mode = 'bricks'`, or the front end renders the (empty) WordPress content instead.

---

## The element array structure (the schema Bricks doesn't officially publish)

A page's content is a **flat array** of element objects (NOT nested) — nesting is expressed by `parent`/`children` IDs that reference other elements in the same array.

```php
[
  [
    'id'       => 'abc123',        // unique 6-char alphanumeric id
    'name'     => 'section',       // element type: section, container, block, heading, text-basic, button, image, icon, etc.
    'parent'   => 0,               // 0 = top level; else the id of the parent element
    'children' => ['def456'],      // array of child element ids (order matters)
    'settings' => [                // element-specific settings (the bulk of the data)
      'tag' => 'section',
      '_padding' => ['top'=>'60','right'=>'0','bottom'=>'60','left'=>'0'],
      // ... style + content controls, keyed by control name
    ],
  ],
  [
    'id'       => 'def456',
    'name'     => 'heading',
    'parent'   => 'abc123',
    'children' => [],
    'settings' => [
      'text' => 'Owner on every job. Start to finish.',
      'tag'  => 'h1',
    ],
  ],
  // ...
]
```

Key rules:
- **Flat array, linked by ids.** A `container`/`block`/`section` lists its child ids in `children`; each child names its `parent`. Top-level elements have `parent => 0`.
- **`name`** is the element type. Layout primitives in current Bricks: **`section`**, **`container`**, **`block`** (use these, not legacy "inner sections"). Plus content elements: `heading`, `text-basic`/`text`, `button`, `image`, `icon`, `nav-menu`, `form`, etc.
- **`settings`** holds everything else — content + styling — keyed by control name (e.g. `text`, `tag`, `_padding`, `_typography`, `_background`). Style controls are prefixed with `_`.
- **ids** are 6-char unique strings within the page. Reusing an id across elements breaks the tree.
- Global classes referenced by id live in the `bricks_global_classes` setting (theme styles).

> No official JSON schema exists (confirmed: the community has repeatedly asked Bricks for one). The reliable way to learn any element's exact `settings` keys is to **build one example in the builder UI, then read its `_bricks_page_content_2`** and copy the shape. We'll do this per element type as we build.

---

## REST API surface (what IS exposed — `bricks/v1`, all read/render)

From `themes/bricks/includes/api.php` (namespace `bricks/v1`):

| Route | Method | Purpose |
|---|---|---|
| `/render_element` | POST | Render an element server-side (builder use) |
| `/get-templates-data/` | GET | Template data |
| `/get-templates/` (+ args) | GET | List/fetch templates (remote template library) |
| `/get-template-authors/`, `/get-template-bundles/`, `/get-template-tags/` | GET | Template library metadata |
| `/render_query_page`, `/render_popup_content`, `/render_query_result` | POST | Render dynamic query/popup output |
| `/get-global-classes-site-usage` | GET | Where global classes are used |

**None write page content.** The remote-templates endpoints are how Bricks pulls from a template provider — relevant if we host our own template library, not for writing this site's pages.

The builder's actual save uses **admin-ajax**, not REST: `wp_ajax_bricks_save_post` (`includes/ajax.php`), nonce-protected, requires builder capability. Not practical to drive headlessly.

---

## Builder access / capabilities
- `bricks_full_access` (full builder) vs `bricks_edit_content` (content only) — `includes/capabilities.php`.
- Administrators get full access automatically. Our API user (admin, ID 1) qualifies.
- SVG upload + code execution are gated separately in Bricks settings (and are intentionally excluded from settings export/import).

---

## Recommended build approach for this site

Given the above, the most efficient path is a **hybrid**:

1. **Generate the design as Bricks template JSON** (one JSON per page/section, matching the element schema above). This is portable, importable, and reviewable.
2. **Build a small library of real element shapes first:** in the builder UI, drop one of each element we'll use (section, container, heading, text, button, image, nav-menu, form/WS Form block), save, and read back `_bricks_page_content_2` to capture exact `settings` keys for v2.3.6. This avoids guessing control names.
3. **Assemble pages** by composing those captured shapes into the flat element array, then write via `update_post_meta($page_id, '_bricks_page_content_2', $elements)` + set `_bricks_editor_mode = 'bricks'`. (Run through Local's PHP against wp-load, the same pattern used for the Meta Box options.)
4. **Header/Footer/Popup:** create `bricks_template` posts with the right `_bricks_template_type` and `_bricks_template_settings` conditions; store the registration popup as an unassigned template.
5. **Forms:** use **WS Form PRO** (installed). Bricks has a native `form` element, but our stack standardizes on WS Form — embed the WS Form shortcode/block, or use the WS Form Bricks integration if present.
6. **Theme styles / colors:** set brand palette (Purple `#401F78`, Gold `#F9C94B`) and typography in `bricks_global_settings` so elements inherit them.

### Things core WP REST still handles (no Bricks needed)
- Page posts: `/wp/v2/pages` (title, slug, status, parent, menu_order)
- Media library uploads, menus, SEO meta (SEOPress), the Meta Box `options` settings page, CPT entries.

## Open confirmations before building in code
- **Capture-first vs hand-author:** confirm we'll seed one example per element in the UI before bulk-writing (strongly recommended — element `settings` keys are version-specific and undocumented).
- **WS Form vs Bricks native form** for the contact form (HANDOFF says WS Form; Bricks native is an option).
- **Child theme:** `blaksheep-creative-bricks-child-v2.1` is active — confirm any global CSS/functions there we should build with rather than around.
