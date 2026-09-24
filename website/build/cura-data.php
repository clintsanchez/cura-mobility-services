<?php
// Cura dynamic data layer: icon library, Service Content field group, Services + FAQs posts.
// Idempotent: re-running updates posts in place (matched by slug / question).
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$svc = require WP_CONTENT_DIR . '/novamira-sandbox/cura-services.php';
$extraFaqs = require __DIR__ . '/cura-faqs-extra.php';
$W = '/Users/clintsanchez/pCloud Drive/Documents/BlakSheep Creative/Clients/Cura Mobility Services/05-Photos/web/';
$log = [];

// 1. Icon library (Font Awesome 6 Free solid, inline SVG) for the card_icon select.
$icons = json_decode(file_get_contents(WP_CONTENT_DIR . '/uploads/cura-import/icons.json'), true);
$lib = [];
foreach ($icons as $k => $svg) { $lib[$k] = ['name' => $k, 'svg' => $svg]; }
update_option('cura_icons', $lib, false);
$log['icons'] = array_keys($lib);

// 2. Services + FAQs CPTs: remove the block editor.
$p = get_post(31); $c = json_decode($p->post_content, true);
// No Gutenberg on Services or FAQs (2026-09-23): the intro and answers live in Meta Box fields.
foreach ([31, 19] as $cptPost) {
  $cp = json_decode(get_post($cptPost)->post_content, true);
  $cp['supports'] = array_values(array_diff($cp['supports'], ['editor']));
  wp_update_post(['ID' => $cptPost, 'post_content' => wp_slash(wp_json_encode($cp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))]);
}

// 3. Service Content field group (Meta Box Builder format, mirrors post 28).
$opts = []; foreach ($lib as $k => $ic) $opts[$k] = ucwords(str_replace('-', ' ', $ic['name']));
$base = ['required' => false, 'disabled' => false, 'readonly' => false, 'clone' => false, 'clone_empty_start' => false, 'hide_from_rest' => false, 'hide_from_front' => false, 'save_field' => true, 'desc' => ''];
$fields = [
  array_merge($base, ['name' => 'Intro', 'id' => 'intro', 'type' => 'wysiwyg', 'raw' => false, 'options' => ['textarea_rows' => 8, 'media_buttons' => false], 'desc' => 'Opening paragraphs on the service page.']),
  array_merge($base, ['name' => 'Card icon', 'id' => 'card_icon', 'type' => 'select', 'options' => $opts, 'placeholder' => 'Select an icon', 'desc' => 'Icon on the service card.']),
  array_merge($base, ['name' => 'Banner image', 'id' => 'banner_image', 'type' => 'single_image', 'desc' => 'Page title background.']),
  array_merge($base, ['name' => 'Detail image', 'id' => 'detail_image', 'type' => 'single_image', 'desc' => 'Photo beside the highlights list.']),
  array_merge($base, ['name' => 'Highlights', 'id' => 'highlights', 'type' => 'group', 'clone' => true, 'sort_clone' => true, 'add_button' => 'Add highlight', 'desc' => 'Short checklist points (about 5).',
    'fields' => [array_merge($base, ['name' => 'Highlight', 'id' => 'text', 'type' => 'text'])]]),
];
$mb = ['title' => 'Service Content', 'id' => 'service-content', 'post_types' => ['services'], 'autosave' => false, 'default_hidden' => false, 'modified' => time(), 'fields' => $fields];
$builderFields = []; foreach ($fields as $f) { $f['_id'] = $f['id']; if (isset($f['fields'])) { $sub = []; foreach ($f['fields'] as $s) { $s['_id'] = $s['id']; $sub[$s['id']] = $s; } $f['fields'] = $sub; } $builderFields[$f['id']] = $f; }
$settings = ['title' => 'Service Content', 'id' => 'service-content', 'object_type' => 'post', 'post_types' => ['services'], 'priority' => 'high', 'style' => 'default', 'closed' => false, 'context' => 'normal', 'autosave' => false, 'default_hidden' => false, 'revision' => false, 'prefix' => '', 'text_domain' => 'your-text-domain', 'modified' => (string) time(), 'custom_table' => ['enable' => false]];
$ex = get_posts(['post_type' => 'meta-box', 'name' => 'service-content', 'post_status' => 'any', 'numberposts' => 1]);
$gid = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'meta-box', 'post_status' => 'publish', 'post_title' => 'Service Content', 'post_name' => 'service-content']);
update_post_meta($gid, 'settings', $settings); update_post_meta($gid, 'fields', $builderFields); update_post_meta($gid, 'meta_box', $mb);
$log['field_group'] = $gid;

// Register now so rwmb/meta writes below behave (normally registered on init by MB Builder).
$img = function ($rel) use ($W) {
  static $alt = null;
  if ($alt === null) { $alt = []; foreach (array_map('str_getcsv', file($W . 'image-map.csv')) as $r) if (isset($r[1])) $alt[$r[0]] = $r[1]; }
  $a = $alt[$rel] ?? ''; $id = cura_upload($W . $rel, $a, $a);
  if (is_wp_error($id)) throw new Exception($rel . ': ' . $id->get_error_message());
  return $id;
};

// 4. Card text + icon per service (originally the Services page icon boxes; kept here since that page now loops).
$cards = [
  'doctor-appointment-rides' => ['stethoscope', 'Rides to checkups, specialists, labs and imaging, with help from the door to check-in.'],
  'dialysis-transportation' => ['droplet', 'Reliable rides to dialysis, three times a week if you need it, on a set schedule.'],
  'wheelchair-transportation' => ['wheelchair', 'Patient, hands-on help for riders who use a wheelchair, walker or scooter.'],
  'hospital-discharge-rides' => ['hospital', 'A calm ride home after a hospital stay, surgery or outpatient procedure.'],
  'treatment-and-therapy-rides' => ['heart-pulse', 'Rides to chemo, infusions, physical therapy and other ongoing treatment.'],
  'senior-and-everyday-rides' => ['person-cane', 'Errands, pharmacy runs, visits with family and other everyday trips.'],
  'prescription-pickup-and-delivery' => ['prescription-bottle-medical', 'We pick up prescriptions and bring them to your door.'],
  'long-distance-medical-transportation' => ['route', 'Rides to specialists and hospitals outside the Baton Rouge area.'],
  'recurring-rides' => ['calendar-check', 'Set it once for dialysis or treatment. We handle every ride after that.'],
];
$svcIds = [];
foreach ($svc as $i => [$slug, $title, $ban, $main, $grid, $intro, $bul, $faqs]) {
  [$iconKey, $cardText] = $cards[$slug];
  $ex = get_posts(['post_type' => 'services', 'name' => $slug, 'post_status' => 'any', 'numberposts' => 1]);
  $postarr = ['post_type' => 'services', 'post_status' => 'publish', 'post_title' => $title, 'post_name' => $slug,
    'post_excerpt' => $cardText, 'post_content' => '', 'menu_order' => $i + 1, 'post_author' => 1];
  if ($ex) $postarr['ID'] = $ex[0]->ID;
  $pid = wp_insert_post(wp_slash($postarr), true);
  if (is_wp_error($pid)) throw new Exception($pid->get_error_message());
  set_post_thumbnail($pid, $img($main));
  update_post_meta($pid, 'intro', '<p>' . str_replace('<br><br>', "</p>\n\n<p>", $intro) . '</p>');
  update_post_meta($pid, 'card_icon', $iconKey);
  update_post_meta($pid, 'banner_image', $img($ban));
  update_post_meta($pid, 'detail_image', $img($grid));
  update_post_meta($pid, 'highlights', array_map(fn($b) => ['text' => $b], $bul));
  $svcIds[$slug] = $pid;

  // Service FAQs (3 from the service file + 2 extra), related via faq_to_service.
  $faqs = array_merge($faqs, $extraFaqs[$slug] ?? []);
  foreach ($faqs as $fi => [$q, $a]) {
    $fid = cura_upsert_faq($q, $a, 'Service questions', $fi + 1);
    if (class_exists('MB_Relationships_API') && !MB_Relationships_API::has($fid, $pid, 'faq_to_service')) MB_Relationships_API::add($fid, $pid, 'faq_to_service');
  }
}
$log['services'] = $svcIds;

// 5. General FAQs (the FAQs page loop). Page 204 no longer holds them, so they are only upserted if listed here;
// existing General FAQ posts are left as they are (edit them in WP admin).
$gen = [];
foreach ((file_exists(__DIR__ . '/cura-faqs-general.php') ? require __DIR__ . '/cura-faqs-general.php' : []) as $n => [$q, $a]) $gen[] = cura_upsert_faq($q, $a, 'General', $n + 1);
$log['general_faqs'] = $gen;
return $log;

function cura_upsert_faq($q, $a, $cat, $order = 0) {
  $ex = get_posts(['post_type' => 'faqs', 'title' => $q, 'post_status' => 'any', 'numberposts' => 1]);
  $answer = (strpos($a, '<p>') === 0) ? $a : '<p>' . $a . '</p>';
  $arr = ['post_type' => 'faqs', 'post_status' => 'publish', 'post_title' => $q, 'post_content' => '', 'menu_order' => $order, 'post_author' => 1];
  if ($ex) $arr['ID'] = $ex[0]->ID;
  $id = wp_insert_post(wp_slash($arr), true);
  if (is_wp_error($id)) throw new Exception($id->get_error_message());
  update_post_meta($id, 'question', $q); update_post_meta($id, 'answer', $answer);
  $term = term_exists($cat, 'faq-categories') ?: wp_insert_term($cat, 'faq-categories');
  wp_set_object_terms($id, (int) $term['term_id'], 'faq-categories');
  return $id;
}
