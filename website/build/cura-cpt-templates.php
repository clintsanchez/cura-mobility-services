<?php
// Cura: single templates for the BSC blueprint CPTs Policies, Forms and Confirmations.
// Layout follows Clint's other sites (LSS / Tiger Town / RWC Elementor templates): interior banner with dynamic
// title + breadcrumb, then a 66/33 row: main content left, sticky sidebar right with a "Get in touch" contact
// card + CTA, then a list of link buttons (policies on policy pages, services on form/confirmation pages).
// Built from the Single Service template (1387) so the sidebar buttons, cards and spacing are the pack's.
// Idempotent (templates matched by title).
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$W = '/Users/clintsanchez/pCloud Drive/Documents/BlakSheep Creative/Clients/Cura Mobility Services/05-Photos/web/';
$log = [];
$svcTpl = get_posts(['post_type' => 'breakdance_template', 'title' => 'Single Service', 'numberposts' => 1])[0]->ID;
[$sj, $base] = cura_bd_load($svcTpl);
[$cj, $contact] = cura_bd_load(186);
[$bj, $book] = cura_bd_load(206);

$img = function ($rel, $alt) use ($W) { return cura_bd_image(cura_upload($W . $rel, $alt, $alt)); };
$dynText = function ($slug) { $d = cura_bd_dyn($slug); return ['text' => $d['shortcode'], 'text_dynamic_meta' => $d['meta']]; };
$node = fn($type, $props) => ['id' => 0, 'data' => ['type' => 'EssentialElements\\' . $type, 'properties' => $props], 'children' => []];
$props = fn($tree, $id) => cura_bd_node($tree['root'], $id)['data']['properties'];
$template = function ($title, $type, $tree) {
  $ex = get_posts(['post_type' => 'breakdance_template', 'title' => $title, 'post_status' => 'any', 'numberposts' => 1]);
  $id = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'breakdance_template', 'post_status' => 'publish', 'post_title' => $title]);
  update_post_meta($id, '_breakdance_template_settings', wp_slash(json_encode(json_encode(['type' => $type, 'ruleGroups' => [], 'priority' => 20]))));
  cura_bd_save($id, ['tree_json_string' => ''], $tree);
  return $id;
};

// Pack pieces reused in every template.
$label = $props($base, 136);                                  // small navy eyebrow label ("Questions")
$h2    = $props($base, 128);                                  // main column heading
$body  = $props($base, 129);                                  // main column text
$cta   = $props($book, 159);                                  // navy primary button
$contactBoxes = array_map(fn($id) => ['id' => 0, 'data' => cura_bd_node($contact['root'], $id)['data'], 'children' => []], [124, 125, 122]); // phone, email, service area

/**
 * Build one template tree.
 * $bannerImg  image object for the page banner
 * $linksTitle heading of the link-button card ("Our policies" / "Our services")
 * $linksPT    post type the link buttons list
 * $main       array of nodes for the 66% column
 */
$build = function ($bannerImg, $linksTitle, $linksPT, array $main) use ($base, $label, $cta, $contactBoxes, $node) {
  $t = $base;
  // Drop the service-only reviews section.
  $t['root']['children'] = array_values(array_filter($t['root']['children'], fn($c) => !in_array('cura-reviews-section', $c['data']['properties']['settings']['advanced']['classes'] ?? [])));
  cura_bd_set($t, 100, 'design.background.image.breakpoint_base', $bannerImg);

  // Sidebar (column 111 -> 33%, right, sticky): contact card, then link buttons.
  cura_bd_set($t, 111, 'design.size.width', ['number' => 33.33, 'unit' => '%', 'style' => '33.33%']);
  cura_bd_set($t, 111, 'settings.advanced.classes', ['cura-sticky-sidebar']);
  cura_bd_set($t, 115, 'content.content.text', $linksTitle);
  $w = function (&$n) use (&$w, $linksPT) { if (empty($n['children'])) return; foreach ($n['children'] as &$c) {
    if (($c['data']['type'] ?? '') === 'EssentialElements\\PostsLoop' && !in_array('cura-faq-loop', $c['data']['properties']['settings']['advanced']['classes'] ?? [])) {
      $c['data']['properties']['content']['query']['query']['php'] = "return ['post_type' => '$linksPT', 'posts_per_page' => 20, 'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC']];";
      $c['data']['properties']['content']['query']['query']['custom']['postTypes'] = [$linksPT];
    } $w($c); } unset($c); };
  $w($t['root']);
  // Contact card = the pack's white sidebar card (162), refilled.
  $card = &cura_bd_node($t['root'], 162);
  $lbl = $label; $lbl['content']['content']['text'] = 'Get in touch';
  $btn = $cta; $btn['content']['content']['text'] = 'Book a ride'; $btn['content']['content']['link'] = ['type' => 'url', 'url' => home_url('/book-a-ride/')];
  $btn['settings']['advanced']['classes'] = ['cura-sidebar-cta'];
  $card['children'] = array_merge([$node('Text', $lbl)], $contactBoxes, [$node('Button', $btn)]);
  $card['data']['properties']['settings']['advanced']['classes'] = ['cura-contact-card'];
  foreach ($card['children'] as &$c) cura_bd_reid($c, $t); unset($c, $card);
  // Contact card first, then the link-button card (126).
  $col = &cura_bd_node($t['root'], 111);
  usort($col['children'], fn($a, $b) => ($a['id'] == 162 ? 0 : 1) <=> ($b['id'] == 162 ? 0 : 1));
  unset($col);

  // Main (column 112 -> 66%, left).
  cura_bd_set($t, 112, 'design.size.width', ['number' => 66.67, 'unit' => '%', 'style' => '66.67%']);
  $m = &cura_bd_node($t['root'], 112);
  $m['children'] = $main;
  foreach ($m['children'] as &$c) cura_bd_reid($c, $t); unset($c, $m);
  $row = &cura_bd_node($t['root'], 110);
  usort($row['children'], fn($a, $b) => ($a['id'] == 112 ? 0 : 1) <=> ($b['id'] == 112 ? 0 : 1));
  unset($row);
  return $t;
};

// ---- Single Policy -------------------------------------------------------------------------------
$h = $h2; $h['content']['content'] = array_merge($h['content']['content'], $dynText('post_title'));
$p = $body; $p['content']['content'] = $dynText('post_content'); $p['settings']['advanced']['classes'] = ['cura-prose'];
$t = $build($img('local-baton-rouge/louisiana-state-capitol-baton-rouge.webp', 'Louisiana State Capitol tower in downtown Baton Rouge against a blue sky'),
  'Our policies', 'policies', [$node('Heading', $h), $node('Text', $p)]);
$log['policy'] = $template('Single Policy', 'policies', $t);

// ---- Single Form ---------------------------------------------------------------------------------
$l = $label; $l['content']['content']['text'] = 'Request form';
$h = $h2; $h['content']['content'] = array_merge($h['content']['content'], $dynText('post_title'));
$intro = $body; $intro['content']['content'] = $dynText('post_excerpt'); $intro['settings']['advanced']['classes'] = ['cura-form-lede'];
$form = ['content' => ['content' => $dynText('post_content')], 'settings' => ['advanced' => ['classes' => ['cura-form-embed']]]];
$t = $build($img('home-booking/daughter-and-senior-mother-looking-at-phone.webp', 'Adult daughter and her senior mother smiling at a phone together on the sofa'),
  'Our services', 'services', [$node('Text', $l), $node('Heading', $h), $node('Text', $intro), $node('Text', $form)]);
$log['form'] = $template('Single Form', 'forms', $t);

// ---- Single Confirmation (the form layout, with a thank-you) ------------------------------------------
$l = $label; $l['content']['content'] = $dynText('post_title');
$h = $h2; unset($h['content']['content']['text_dynamic_meta']); $h['content']['content']['text'] = 'Thank you. We got your request.';
$msg = $body; $msg['content']['content'] = ['text' => '<p>We will call you soon to confirm the details.</p><p><strong>What happens next</strong></p><ol><li>We review your request.</li><li>We call you to confirm the pickup, the ride type and any mobility needs.</li><li>You get a clear price before anything is booked.</li></ol><p>Need us sooner? Call or text <a href="tel:+12253630845">(225) 363-0845</a>. For a medical emergency, call 911.</p>'];
$msg['settings']['advanced']['classes'] = ['cura-prose'];
$home = $cta; $home['content']['content']['text'] = 'Back to home'; $home['content']['content']['link'] = ['type' => 'url', 'url' => home_url('/')];
$call = $cta;
$btns = ['id' => 0, 'data' => ['type' => 'EssentialElements\\Div', 'properties' => ['settings' => ['advanced' => ['classes' => ['cura-button-row']]]]], 'children' => [$node('Button', $home), $node('Button', $call)]];
$t = $build($img('home-rider/senior-woman-laughing-as-car-passenger.webp', 'Senior woman laughing while riding as a passenger in a car'),
  'Our services', 'services', [$node('Text', $l), $node('Heading', $h), $node('Text', $msg), $btns]);
$log['confirmation'] = $template('Single Confirmation', 'confirmation', $t);

// ---- Styles --------------------------------------------------------------------------------------
$css = "/* CPT single templates (Policy / Form / Confirmation): 66/33 with sticky right sidebar */\n.breakdance .cura-sticky-sidebar{position:sticky;top:150px;align-self:flex-start}\n@media (max-width:1023px){.breakdance .cura-sticky-sidebar{position:static}}\n.breakdance .cura-contact-card{gap:14px}\n.breakdance .cura-contact-card .bde-icon-box{width:100%;margin:0!important}\n.breakdance .cura-sidebar-cta{width:100%}\n.breakdance .cura-sidebar-cta .button-atom{width:100%;justify-content:center}\n/* Long-form text */\n.cura-prose{font-size:16px;line-height:1.7}\n.cura-prose h2{font-size:24px;margin:32px 0 12px}\n.cura-prose h3{font-size:20px;margin:24px 0 10px}\n.cura-prose p{margin:0 0 16px}\n.cura-prose ul,.cura-prose ol{margin:0 0 16px;padding-left:22px}\n.cura-prose li{margin-bottom:6px}\n.cura-prose a{color:#047878;text-decoration:underline}\n/* Form embed card */\n.breakdance .cura-form-embed{width:100%;margin-top:10px}\n.breakdance .cura-form-embed:not(:empty){background:#fff;border-radius:20px;box-shadow:0 15px 40px rgba(2,38,90,.08);padding:25px}\n/* Confirmation buttons */\n.breakdance .cura-button-row{display:flex;flex-direction:row;flex-wrap:wrap;gap:12px;margin-top:8px}";
$gs = json_decode(json_decode(get_option('breakdance_global_settings_json_string')), true); $ss = $gs['settings']['code']['stylesheets'];
$pos = array_search('Cura: CPT templates', array_column($ss, 'name')); $e = ['name' => 'Cura: CPT templates', 'code' => $css];
if ($pos === false) $ss[] = $e; else $ss[$pos] = $e;
$gs['settings']['code']['stylesheets'] = $ss; \Breakdance\Data\save_global_settings(json_encode(['settings' => $gs['settings']]));
\Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles(); \Breakdance\Render\generateCacheForGlobalSettings();
foreach (array_merge(array_values($log), [67, 176, 244, 180, 182, 186, 202, 204, 206, 208, 1383, 1384, 1385, 1386, 1387, 1454, 1456, 1485]) as $id) \Breakdance\Render\generateCacheForPost($id);
return $log;
