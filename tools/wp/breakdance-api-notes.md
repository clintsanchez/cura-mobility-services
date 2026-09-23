# Breakdance Developer APIs — notes for the Tiger Town build

Scoured from the official docs (breakdance.com/documentation/developers/apis/) and the
authoritative source repo **github.com/soflyy/breakdance-developer-docs**. These are the
PHP/JS hooks we can actually use. Custom PHP goes in a small mu-plugin or a code-snippets
plugin on the site.

## ⭐ The big constraint (decides how we build pages)
**There is NO public API to create or import a Breakdance PAGE LAYOUT (the builder tree).**
None of the documented APIs write page content. Breakdance stores each page's builder data in
**post meta** in its own serialized JSON-ish format (the `_breakdance_data` family of keys),
which is internal/undocumented and not exposed for safe REST/programmatic authoring.

**Implication for our workflow:**
- **Page *designs* / layouts → build in the Breakdance UI** (or duplicate a template, or use a
  Breakdance design "preset"/export-import inside the builder). Not scriptable from outside.
- **Everything that *feeds* the pages IS scriptable via WP REST** (our `wp.py` toolkit):
  CPT entries (`services`, `locations`, `team`, `review`, `faqs`, `products`), their Meta Box
  fields, taxonomy terms, the Media Library (the 1,250 photos), menus, and SEOPress meta.
- So the division of labor: **REST loads the data + media + SEO; Breakdance UI lays out the
  templates** that render that data via Dynamic Data. Build a CPT *single template* once in
  Breakdance, and every CPT entry we push via REST renders through it.

## APIs we will likely use

### 1. Dynamic Data API — pull our Meta Box (and any) fields into Breakdance elements
Register a custom Dynamic Field so Breakdance's data chooser can output a value (e.g. a Meta Box
field on a service). Breakdance already integrates Meta Box's data chooser, so often we won't
need custom fields — but if we do:
```php
add_action('init', function () {
    if (!function_exists('\Breakdance\DynamicData\registerField') ||
        !class_exists('\Breakdance\DynamicData\StringField')) return;

    class TTC_Field extends \Breakdance\DynamicData\StringField {
        public function label()    { return 'TTC Field'; }
        public function category() { return 'Tiger Town'; }
        public function slug()     { return 'ttc_field'; }
        public function handler($attributes): \Breakdance\DynamicData\StringData {
            $v = (string) get_post_meta(get_the_ID(), 'meta_key', true);
            return \Breakdance\DynamicData\StringData::fromString($v);
        }
    }
    \Breakdance\DynamicData\registerField(new TTC_Field());
});
```
Base classes: `StringField`, `ImageField`, `GalleryField`, `OembedField`.
Methods: required `label()/category()/slug()/handler()`; optional `subcategory()/returnTypes()`.
*(Our Meta Box field groups — `website/wp-build/*.mb-fields.json` — should expose their fields to
Breakdance's built-in Meta Box dynamic-data integration once imported, so custom fields are a
fallback, not the default.)*

### 2. Form Actions API — wire quote-form submissions (alternative/supplement to WS Form)
Breakdance's own Form Builder can run a custom "Action After Submission" (e.g. push a lead to
GHL `WLLbl1zZpIyUQ534mHjf`, or email ttconstruction225@gmail.com + clint@clintsanchez.com).
Extend `\Breakdance\Forms\Actions\Action`:
```php
add_action('init', function () {
    if (!function_exists('\Breakdance\Forms\Actions\registerAction') ||
        !class_exists('\Breakdance\Forms\Actions\Action')) return;

    class TTC_QuoteAction extends \Breakdance\Forms\Actions\Action {
        public function name() { return 'Send to Tiger Town CRM'; }
        public function slug() { return 'ttc_quote_action'; }
        public function run($form, $settings, $extra) {
            // $extra: submittedFields, files, formId, postId, ip, referrer, userAgent, userId
            // ... push to GHL / email ...
            return ['type' => 'success', 'message' => 'Thanks — Justin will be in touch.'];
        }
    }
    \Breakdance\Forms\Actions\registerAction(new TTC_QuoteAction());
});
```
*Note:* the site also has the **WS Form** plugin (`ws-form/v1`), which is the heavier
form tool. Decide per form whether to use WS Form or a native Breakdance form + this action.

### 3. Element Display Conditions API — show/hide elements by rule
Declarative, no class needed. Useful for e.g. show a "Most Requested" badge only on
patio-covers/screen-rooms, or location-specific blocks.
```php
add_action('breakdance_register_template_types_and_conditions', function () {
    \Breakdance\ConditionsAPI\register([
        'supports'  => ['element_display'],
        'slug'      => 'ttc-service-is-priority',
        'label'     => 'Service is priority',
        'category'  => 'Tiger Town',
        'operands'  => ['equals', 'not equals'],
        'callback'  => function (string $operand, $value) { /* ... */ return true; },
    ]);
});
```

### 4. Global Settings API — register brand tokens in Breakdance Global Settings
We can register Tiger Town brand controls (purple `#401F78` / gold `#F9C94B`) as global settings,
then reference them in element CSS via Twig `{{ settings.section_id.control_id }}`.
```php
add_filter('breakdance_global_settings_control_sections_append', function ($sections) {
    $s = controlSection('ttc_brand', 'Tiger Town Brand', [
        control('purple', 'Purple', ['type' => 'color', 'layout' => 'inline']),
        control('gold',   'Gold',   ['type' => 'color', 'layout' => 'inline']),
    ]);
    return array_merge($sections, [$s]);
});
```
(Usually simpler to just set Breakdance's built-in Global Colors in the UI — but this is the API.)

### 5. Template Override Filter — control when Breakdance renders
```php
add_filter('breakdance_should_override_template', function ($shouldOverride, $file_to_include) {
    // return false to hand a given request back to WP / another plugin
    return $shouldOverride;
}, 10, 2);
```

### 6. Menu API (JS) — control the nav menu element at runtime
```js
const menu = document.querySelector('.breakdance-menu').bdMenu;
menu.toggleMobileMenu(); menu.closeAll(); menu.isMobile();
// openDropdown(node), closeDropdown(node), getOpenDropdown(), refreshDropdowns(), isDesktop(), isVertical()
```

### 7. Popups API (JS) — open/close popups (e.g. a "Request a Quote" popup)
```js
BreakdancePopup.runAction(popupId, 'open');   // or 'close'
// popupId = the number shown when hovering the popup's name in Breakdance → Popups
```

## Form Builder render hooks (PHP actions, for tweaking form markup)
- `breakdance_form_start($settings)` — start of form render
- `breakdance_form_before_field($field, $settings)` / `breakdance_form_after_field(...)` — per field
- `breakdance_form_before_footer($settings)` — before footer (inject buttons)
- `breakdance_form_end($settings)` — after the form markup

## Other useful global hooks
- **`breakdance_after_save_document($postId)`** (action) — fires when a Breakdance doc is saved in
  the builder. Handy for cache-busting or syncing after manual edits.
- **`breakdance_singular_content($content)`** (filter) — gate/modify singular post content.
- **`breakdance_append_dependencies($deps)`** (filter) — add/remove CSS/JS dependencies.
- **`breakdance_element_classnames_for_html_class_attribute($classNames)`** (filter) — add classes.
- **`breakdance_query_builder_input_query($query)`** (filter) — modify query-builder queries
  (e.g. integrate WP Grid Builder / facets on the project gallery).
- **`breakdance_register_font($font)`** (filter) — disable/manage fonts (e.g. kill Google Fonts,
  self-host Poppins/Source Sans 3).
- **`breakdance_shape_dividers($dividers)`** (filter) — add custom SVG section dividers.

## Other documented APIs (lower priority for us)
- **Animations API** (JS) · **Dependencies API** (register reusable CSS/JS) · **AI Endpoints API** ·
  **"Adding an API Key field to Breakdance's Settings"** · **Breakdance Form Submissions Capability**
  (the capability that gates who can view stored form submissions).

## Bottom line for the build plan
1. **REST (wp.py):** create/populate CPT entries + Meta Box fields, upload the 1,250 photos with
   alt text, build menus, set SEOPress meta. ✅ all working.
2. **Breakdance UI:** build the header/footer + one single-template per CPT (services, locations) +
   the homepage and key pages, wiring elements to Dynamic Data (Meta Box fields, WP Grid Builder
   gallery). Not scriptable — done in the builder.
3. **mu-plugin (PHP):** only if we need a custom form action (GHL push), a custom display
   condition, custom dynamic field, or to self-host fonts. Snippets above are ready.
