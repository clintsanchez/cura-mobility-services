<?php
// Cura service landing pages, step 2 (2026-09-24): Single Service template 1387.
// - Hero: H1 + breadcrumb, then the hero_subhead field and two buttons ("Request this ride" jumps to the sidebar
//   form #request-ride; "Call (225) 363-0845" outlined).
// - Content column: after the highlights, three sections: "Who this ride is for" (who_for field), "How booking a
//   ride works" (3 static steps), "Serving the Baton Rouge area". Section H2s + area text come from per-service
//   fields (who_heading, how_heading, area_heading, area_text) with the generic text as fallback. FAQ kicker removed; the FAQ H2 uses the
//   faq_heading field (fallback "Common questions").
// - Mobile/tablet: the sidebar (services list + form) follows the content (CSS order, "Cura: service landing").
// - Footer CTA (global footer 244): "Request a ride" button next to the phone button.
// Idempotent: new nodes carry cura-svc-* classes and are rebuilt on re-run.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$log = [];
[$j, $t] = cura_bd_load(1387);

$cls = fn(array $c) => ['settings' => ['advanced' => ['classes' => $c]]];
$hasCls = function ($n, $c) { return in_array($c, $n['data']['properties']['settings']['advanced']['classes'] ?? [], true); };
// Remove anything a previous run added.
$strip = function (&$n) use (&$strip, $hasCls) {
  if (empty($n['children'])) return;
  $n['children'] = array_values(array_filter($n['children'], function ($c) use ($hasCls) {
    foreach (['cura-hero-subhead', 'cura-hero-ctas', 'cura-svc-section'] as $k) if ($hasCls($c, $k)) return false;
    return true;
  }));
  foreach ($n['children'] as &$c) $strip($c); unset($c);
};
$strip($t['root']);

// Button styles: white solid (primary on dark backgrounds) and white outline (phone, secondary).
[, $foot] = cura_bd_load(244);
$phoneProps = null; // the footer phone button (found by its tel: link; its node id changed when it moved into the button row)
$findPhone = function ($n) use (&$findPhone, &$phoneProps) {
  if ($phoneProps === null && ($n['data']['type'] ?? '') === 'EssentialElements\\Button' && ($n['data']['properties']['content']['content']['link']['url'] ?? '') === 'tel:+12253630845' && !empty($n['data']['properties']['design']['button']['custom']['outline'])) $phoneProps = $n['data']['properties'];
  foreach (($n['children'] ?? []) as $c) $findPhone($c);
};
$findPhone($foot['root']);
$outline = $phoneProps['design'];
$solid = $outline;
$solid['button']['custom']['outline'] = false;
$solid['button']['custom']['background'] = '#FFFFFFFF';
$solid['button']['custom']['typography']['color']['breakpoint_base'] = '#02265AFF';
$solid['button']['custom']['typography']['typography']['custom']['customTypography']['fontWeight']['breakpoint_base'] = '600';
$solid['button']['custom']['background_hover'] = '#E6F4F4FF';
$solid['button']['custom']['color_hover'] = '#02265AFF';
unset($solid['button']['custom']['icon']);
$btn = fn($text, $url, $design, array $classes = []) => cura_bd_el('Button', ['content' => ['content' => ['text' => $text, 'link' => ['type' => 'url', 'url' => $url]]], 'design' => $design] + ($classes ? $cls($classes) : []));

// Hero.
$sub = cura_bd_dyn('metabox_field_hero_subhead');
$hero = &cura_bd_node($t['root'], 103);
$heroNew = [];
foreach ($hero['children'] as $c) {
  $heroNew[] = $c;
  if ($c['id'] == 105) {
    $heroNew[] = cura_bd_el('Text', ['content' => ['content' => ['text' => $sub['shortcode'], 'text_dynamic_meta' => $sub['meta']]]] + $cls(['cura-hero-subhead']));
    $heroNew[] = cura_bd_el('Div', $cls(['cura-hero-ctas']), [
      $btn('Request this ride', home_url('/book-a-ride/'), $solid), // every booking button goes to Book a ride (Clint, 2026-09-24)
      $btn('Call (225) 363-0845', 'tel:+12253630845', $outline),
    ]);
  }
}
$hero['children'] = $heroNew;
unset($hero);

// Form anchor.
$form = &cura_bd_node($t['root'], 162);
$form['data']['properties']['settings']['advanced']['id'] = 'request-ride';
$form['data']['properties']['settings']['advanced']['classes'] = array_values(array_unique(array_merge($form['data']['properties']['settings']['advanced']['classes'] ?? [], ['cura-request-ride'])));
unset($form);

// Column classes for the mobile order.
foreach ([111 => 'cura-svc-sidebar', 112 => 'cura-svc-main'] as $id => $c) {
  $n = &cura_bd_node($t['root'], $id);
  $n['data']['properties']['settings']['advanced']['classes'] = [$c];
  unset($n);
}

// Content sections.
$h2 = fn($text) => cura_bd_el('Heading', ['content' => ['content' => ['text' => $text, 'tags' => 'h2']], 'design' => ['spacing' => ['margin_bottom' => ['breakpoint_base' => ['number' => 15, 'unit' => 'px', 'style' => '15px']]]]]);
$h3 = fn($text) => cura_bd_el('Heading', ['content' => ['content' => ['text' => $text, 'tags' => 'h3']]] + $cls(['cura-step-title']));
$txt = fn($html, array $c = []) => cura_bd_el('Text', ['content' => ['content' => ['text' => $html]]] + ($c ? $cls($c) : []));
$who = cura_bd_dyn('metabox_field_who_for');
// Per-service H2s (fields added in cura-service-landing-headings.php), with the old generic text as fallback.
$dynH2 = function ($field, $fallback) {
  $d = cura_bd_dyn("metabox_field_$field", ['fallback' => $fallback]);
  return cura_bd_el('Heading', ['content' => ['content' => ['text' => $d['shortcode'], 'text_dynamic_meta' => $d['meta'], 'tags' => 'h2']], 'design' => ['spacing' => ['margin_bottom' => ['breakpoint_base' => ['number' => 15, 'unit' => 'px', 'style' => '15px']]]]]);
};
$areaT = cura_bd_dyn('metabox_field_area_text');
$sections = [
  cura_bd_el('Div', $cls(['cura-svc-section', 'cura-svc-who']), [
    $dynH2('who_heading', 'Who this ride is for'),
    cura_bd_el('Text', ['content' => ['content' => ['text' => $who['shortcode'], 'text_dynamic_meta' => $who['meta']]]] + $cls(['cura-svc-who-text'])),
  ]),
  cura_bd_el('Div', $cls(['cura-svc-section', 'cura-svc-how']), [
    $dynH2('how_heading', 'How booking a ride works'),
    cura_bd_el('Div', $cls(['cura-steps']), [
      cura_bd_el('Div', $cls(['cura-step']), [$h3('Call or request a ride'), $txt('Call <a href="tel:+12253630845">(225) 363-0845</a> or send a ride request with the pickup, destination and appointment time.')]),
      cura_bd_el('Div', $cls(['cura-step']), [$h3('We confirm the details'), $txt('We call to confirm the ride, any mobility needs and a clear price before anything is booked.')]),
      cura_bd_el('Div', $cls(['cura-step']), [$h3('We help from door to door'), $txt('Your driver helps you from your door to the car and all the way to where you are going.')]),
    ]),
  ]),
  cura_bd_el('Div', $cls(['cura-svc-section', 'cura-svc-area']), [
    $dynH2('area_heading', 'Serving the Baton Rouge area'),
    cura_bd_el('Text', ['content' => ['content' => ['text' => $areaT['shortcode'], 'text_dynamic_meta' => $areaT['meta']]]] + $cls(['cura-svc-area-text'])),
  ]),
];
$main = &cura_bd_node($t['root'], 112);
$mainNew = [];
foreach ($main['children'] as $c) {
  if ($c['id'] == 136) continue; // "Questions" kicker
  $mainNew[] = $c;
  if ($c['id'] == 130) foreach ($sections as $s) $mainNew[] = $s; // after the highlights grid
}
$main['children'] = $mainNew;
unset($main);

// FAQ heading from the field.
$faq = cura_bd_dyn('metabox_field_faq_heading', ['fallback' => 'Common questions']);
$fh = &cura_bd_node($t['root'], 135);
$fh['data']['properties']['content']['content']['text'] = $faq['shortcode'];
$fh['data']['properties']['content']['content']['text_dynamic_meta'] = $faq['meta'];
$fh['data']['properties']['settings']['advanced']['classes'] = ['cura-svc-faq-heading'];
unset($fh);

// Give new nodes ids.
$reid = function (&$n) use (&$reid, &$t) { if (($n['id'] ?? 0) === 0) cura_bd_reid($n, $t); elseif (!empty($n['children'])) { foreach ($n['children'] as &$c) $reid($c); unset($c); } };
$reid($t['root']);
cura_bd_save(1387, $j, $t);
$log['template'] = 1387;

// Footer CTA: add "Request a ride" (white solid) before the phone button, both in a row.
[$fj, $ft] = cura_bd_load(244);
$col = &cura_bd_node($ft['root'], 110);
$already = false;
foreach ($col['children'] as $c) if ($hasCls($c, 'cura-footer-cta-buttons')) $already = true;
if (!$already) {
  $out = []; $phone = null;
  foreach ($col['children'] as $c) { if ($c['id'] == 114) { $phone = $c; continue; } $out[] = $c; }
  $out[] = cura_bd_el('Div', $cls(['cura-footer-cta-buttons']), [$btn('Request a ride', home_url('/book-a-ride/'), $solid), $phone]);
  $col['children'] = $out;
}
unset($col);
$reid2 = function (&$n) use (&$reid2, &$ft) { if (($n['id'] ?? 0) === 0) cura_bd_reid($n, $ft); elseif (!empty($n['children'])) { foreach ($n['children'] as &$c) $reid2($c); unset($c); } };
$reid2($ft['root']);
cura_bd_save(244, $fj, $ft);
$log['footer'] = $already ? 'already' : 'added';

// CSS.
$css = <<<'CSS'
/* Single Service as a landing page (template 1387): hero subheading + CTAs, content sections, mobile order */
.breakdance .cura-hero-subhead{color:white;font-size:18px;line-height:1.5;max-width:680px;text-align:center;margin:6px auto 0}
.breakdance .cura-hero-ctas{display:flex;flex-direction:row;align-items:center;flex-wrap:wrap;justify-content:center;gap:14px;margin-top:8px}
.breakdance .cura-request-ride{scroll-margin-top:140px}
.breakdance .cura-svc-section{margin:45px 0 0;width:100%}
.breakdance .cura-svc-who-text ul{margin:10px 0 0;padding-left:22px}
.breakdance .cura-svc-who-text li{margin:0 0 6px}
.breakdance .cura-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;counter-reset:cura-step}
.breakdance .cura-step{background:#F3F6F9;border-radius:14px;padding:24px 22px;counter-increment:cura-step}
.breakdance .cura-step::before{content:counter(cura-step);display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:#02265A;color:white;font-family:Montserrat,Arial,sans-serif;font-weight:700;font-size:18px;margin-bottom:14px}
.breakdance .cura-step .cura-step-title{font-size:19px;margin:0 0 8px}
.breakdance .cura-step p,.breakdance .cura-step .bde-text{margin:0;font-size:16px}
.breakdance .cura-svc-area p{margin:0 0 10px}
.breakdance .cura-svc-faq-heading{margin-top:45px}
.breakdance .cura-footer-cta-buttons{display:flex;flex-direction:row;align-items:center;flex-wrap:wrap;justify-content:center;gap:14px}
@media (max-width:1119px){
  .breakdance .cura-svc-main{order:1}
  .breakdance .cura-svc-sidebar{order:2}
}
@media (max-width:767px){
  .breakdance .cura-steps{grid-template-columns:1fr}
  .breakdance .cura-hero-ctas,.breakdance .cura-footer-cta-buttons{flex-direction:column;align-items:stretch;width:100%;max-width:360px;margin-left:auto;margin-right:auto}
  .breakdance .cura-hero-ctas .bde-button,.breakdance .cura-footer-cta-buttons .bde-button{width:100%}
  .breakdance .cura-hero-ctas .bde-button__button,.breakdance .cura-footer-cta-buttons .bde-button__button{width:100%;justify-content:center}
}
CSS;
$gs = json_decode(json_decode(get_option('breakdance_global_settings_json_string')), true);
$ss = &$gs['settings']['code']['stylesheets'];
$pos = array_search('Cura: service landing', array_column($ss, 'name'));
$e = ['name' => 'Cura: service landing', 'code' => $css];
if ($pos === false) $ss[] = $e; else $ss[$pos] = $e;
unset($ss);
\Breakdance\Data\save_global_settings(json_encode(['settings' => $gs['settings']]));
\Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles();
\Breakdance\Render\generateCacheForGlobalSettings();
foreach ([67, 176, 244, 180, 182, 186, 202, 204, 206, 208, 1387, 1487, 1488, 1489, 1513, 369, 392, 396, 454, 1547, 1549, 1550, 1383, 1384, 1385, 1386, 1454, 1456, 1485] as $p) \Breakdance\Render\generateCacheForPost($p);
$log['css'] = strlen($css);
return $log;
