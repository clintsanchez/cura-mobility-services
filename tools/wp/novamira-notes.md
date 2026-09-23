# Novamira + Novamira Pro — what they are and what we can do

*Installed & active on the Bricks site (`tiger-town-construction-bricks.local`): **Novamira v1.6.0** + **Novamira Pro v1.1.2**. Verified against the live plugin source + the Novamira MCP endpoint (handshake succeeds with our existing Application Password). NOT installed on the original Breakdance site.*

## What it is — the big unlock
**Novamira is an MCP server baked into WordPress.** It lets an AI agent (this Claude Code session) talk to the WP install over the Model Context Protocol and execute real operations. **Novamira Pro adds ~40 Bricks-specific "abilities"** that read and WRITE Bricks page content, templates, styles, components, etc. — at the element level, no manual JSON-into-postmeta patching.

This directly solves the gap from [bricks-api-notes.md](bricks-api-notes.md): Bricks itself has no write REST API, but **Novamira Pro is exactly that write layer** (and it understands the element schema for this Bricks version, so we don't have to reverse-engineer it).

> Dev/staging only by design. PHP execution is sandboxed to a directory; every action is approval-gated in the client. Keep backups (we have one: `.backups/bricks-2026-06-08-pre-breakdance-removal.sql.gz`).

## Connection (MCP endpoint — verified live)
- **Endpoint:** `https://tiger-town-construction-bricks.local/wp-json/mcp/novamira` (transport: HTTP/JSON-RPC). Legacy alias `/wp-json/mcp/mcp-adapter-default-server` also exists.
- **Auth:** WordPress **Application Password**, Basic auth — the SAME `WP_USER` / `WP_APP_PASSWORD` already in `.env` work (confirmed: `initialize` handshake returns 200, serverInfo "Novamira v1.0.0"; unauthed = 401). The Novamira → Connect admin page can also mint a dedicated app password and pre-encode the header.
- **Add to Claude Code** (HTTP transport, no Node needed) — project `.mcp.json`:
  ```json
  {
    "mcpServers": {
      "novamira": {
        "type": "http",
        "url": "https://tiger-town-construction-bricks.local/wp-json/mcp/novamira",
        "headers": { "Authorization": "Basic <base64(user:app_password)>" }
      }
    }
  }
  ```
  (LocalWP self-signed cert: the client must allow the insecure cert, same as our `curl -k`.)
- After connecting, the **authoritative ability list comes from MCP discovery** (`tools/list`) — names, params, and schemas for this exact version. The list below is from the installed source.

## Core primitives (base Novamira — works with ANY stack)
Execute PHP (30s limit, sandboxed), Read / Write / Edit / Delete / Disable / Enable file, List directory, Create upload link. = full filesystem + live PHP runtime against WP.

## Bricks abilities (Novamira Pro) — the build toolkit
Prefix `novamira/`. Grouped by what they do:

**Page content (the core build loop)**
- `bricks-check-setup` — verify Bricks active, license, supported post types
- `bricks-list-elements` — element schema + control names for THIS version (section/container/block/heading/text-basic/button/image/nav-menu/form/…). This is the schema source.
- `bricks-list-settings` / `bricks-get-settings` / `bricks-set-settings` — page-level layout settings (full-bleed, disable header/footer, body classes, custom CSS/scripts, `postTypes`)
- `bricks-get-content` — read a page's element tree
- `bricks-set-content` — write the full element tree (new pages)
- `bricks-insert-content` / `bricks-remove-content` — add/remove a section/subtree in an existing tree
- `bricks-patch-elements` — targeted edits to individual elements (don't rewrite the whole page)

**Templates (header/footer/popup/archive/single)**
- `bricks-create-template`, `bricks-list-templates`
- `bricks-list-template-conditions` / `bricks-set-template-conditions` / `bricks-list-template-condition-schema` — where a template applies

**Components (reusable, cross-page)**
- `bricks-list-components`, `bricks-create-component`, `bricks-apply-component`, `bricks-edit-component`, `bricks-delete-component`

**Design system / global styles**
- Color palette: `bricks-list-color-palette`, `bricks-get/add/edit/delete-color-palette-entry`
- Global classes: `bricks-list/get/create/edit/delete-global-class`, `bricks-apply-global-class`
- Theme styles (h1–h6/p/a/button defaults): `bricks-list/get/create/edit/delete-theme-style`
- Variables (spacing/type tokens): `bricks-list-variables` (+ create-variable per the skill)

**Dynamic data & interactions**
- `bricks-list-dynamic-data`, `bricks-resolve-dynamic-data` — bind CMS/field data into elements
- `bricks-list/add/edit/delete-interaction`, `bricks-list-interaction-events-and-actions`

**Other builder/field abilities also present** (conditionally loaded): Elementor, ACF, ACPT, ASE, JetEngine, Pods, Meta Box, generic WordPress, and a **memory** category (typed records: User/Feedback/Project/Reference — cross-session memory inside WP).

## Bundled "skills" (build playbooks shipped with Pro)
Located in `novamira-pro/includes/skills/`. The agent can load these for workflow guidance:
`bricks-build-page`, `dynamic-data-binding`, `content-model-schema`, `content-model-migration`, `metabox-integration`, `acf-integration`, `acpt-integration`, `ase-integration`, `jetengine-integration`, `pods-integration`, `elementor-build-page`, `elementor-convert-to-v4`, `novamira-feedback`.

### The `bricks-build-page` canonical sequence (what it tells the agent to do)
1. **Inventory styles** — list theme styles, variables, global classes, color palette (parallel).
2. **Tokens-first** — derive the design system; create missing color-palette/variables/global-classes/theme-styles BEFORE building. Names kebab-case + semantic (`brand-primary`, `space-md`), never presentational.
3. **`bricks-check-setup`** — ensure `page` is in Bricks `postTypes` (else "Edit with Bricks" won't show / won't render); fix via `bricks-set-settings` global scope.
4. **Create the post** (`create-post` / `wp_insert_post`).
5. **`bricks-set-content`** — populate the element tree, referencing tokens not raw values.
6. **`bricks-set-settings`** — page-level layout. Never pass `templateType` on a regular page.

**Style hierarchy (enforced):** theme-style defaults → global class (`_cssGlobalClasses`) → variable refs (`var(--brand-primary)`) → create token → raw value (one-offs only) → `_cssCustom` (last resort). Hex/px/font/radii must be tokenized, never raw.

**Element hierarchy:** `section → container → block-level` for normal content. For repeated CMS content (blog grid, portfolio, related strip) use a **query loop** (`hasLoop: true` + `query` on the container) instead of N hand-typed cards.

## How this changes our build plan for Tiger Town
The hybrid plan in `bricks-api-notes.md` still holds, but Novamira replaces the manual `update_post_meta` step and removes the "capture element shapes by hand" chore:

1. **Connect Novamira MCP to the session** (`.mcp.json` above).
2. **Set up the design system first** (tokens-first): Purple `#401F78` + Gold `#F9C94B` palette, spacing/type scale, `.btn-primary`/`.card` global classes, theme styles — via the color-palette / variable / global-class / theme-style abilities.
3. **Build each page** with `bricks-set-content` (Home, About, Services, Project Gallery, Contact), section→container→block, query loops for the gallery.
4. **Header/Footer/registration popup** as `bricks_template` posts via `bricks-create-template` + conditions.
5. **WS Form PRO** for the contact form (embed via a Bricks element); core WP REST still handles page posts/media/menus/SEO.
6. Use Novamira **memory** to persist brand tokens + the accuracy guardrails (no "licensed"/license #, no "50+/6–10 yrs", no street address as fact, no fabricated reviews) across sessions.

## Open decision
- **Connect now?** Adding the `.mcp.json` lets me drive Bricks directly from this session (discovery returns the live ability list). Need: confirm we point at the LocalWP host with the self-signed cert allowed, and decide whether to reuse the `.env` app password or mint a dedicated Novamira one via Novamira → Connect.
