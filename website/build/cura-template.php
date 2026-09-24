<?php
// Cura: Single Service template (Breakdance) for the `services` CPT, built from the static service page 1307
// (itself the Pixels Cab "Services Single" layout). Idempotent.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$SRC = 1307; $log = [];
[$sj, $src] = cura_bd_load($SRC);
$props = fn($id) => cura_bd_node($src['root'], $id)['data']['properties'];
$dyn = function ($slug) { return cura_bd_dyn($slug); };
$flush = ['settings' => ['advanced' => ['classes' => ['cura-loop-flush']]]];

// --- Global blocks -------------------------------------------------------
// Sidebar link: the pack's sidebar Button, text/link bound to the service.
$b = $props(117); $t = $dyn('post_title'); $u = $dyn('post_permalink');
$b['content']['content']['text'] = $t['shortcode']; $b['content']['content']['text_dynamic_meta'] = $t['meta'];
$b['content']['content']['link'] = ['type' => 'url', 'url' => $u['shortcode'], 'dynamicMeta' => $u['meta']];
$b['settings']['advanced']['classes'] = ['cura-loop-flush'];
$blkLink = cura_bd_block('Service sidebar link', [['id' => 0, 'data' => ['type' => 'EssentialElements\\Button', 'properties' => $b], 'children' => []]]);

// Highlight: the pack's IconList with one item bound to the highlights subfield.
$il = $props(132); $h = $dyn('metabox_field_highlights_text');
$item = $il['content']['content']['list'][0]; unset($item['link']);
$item['text'] = $h['shortcode']; $item['text_dynamic_meta'] = $h['meta'];
$il['content']['content']['list'] = [$item];
$il['settings']['advanced']['classes'] = ['cura-loop-flush'];
$blkHl = cura_bd_block('Service highlight', [['id' => 0, 'data' => ['type' => 'EssentialElements\\IconList', 'properties' => $il], 'children' => []]]);

// FAQ answer: Text bound to the FAQ post content.
$pc = $dyn('metabox_field_answer'); // FAQ Answer field (no Gutenberg)
$blkFaq = cura_bd_block('FAQ answer', [cura_bd_el('Text', ['content' => ['content' => ['text' => $pc['shortcode'], 'text_dynamic_meta' => $pc['meta']]], 'settings' => ['advanced' => ['classes' => ['cura-faq-answer']]]])]);
$log['blocks'] = compact('blkLink', 'blkHl', 'blkFaq');

// --- Template tree ---------------------------------------------------------
$t = $src; $S = function ($id, $p, $v) use (&$t) { if (!cura_bd_set($t, $id, $p, $v)) throw new Exception("no $id"); };
$query = function ($custom, $php) {
  return ['active' => 'php', 'text' => '', 'php' => $php, 'custom' => array_merge(['source' => 'post_types', 'postsPerPage' => 20, 'conditions' => [[[]]], 'totalPosts' => null, 'ignoreStickyPosts' => true, 'ignoreCurrentPost' => false, 'postTypes' => ['post'], 'orderBy' => 'menu_order', 'order' => 'ASC', 'date' => 'all', 'beforeDate' => null, 'afterDate' => null, 'offset' => null, 'acfField' => null, 'metaboxField' => null], $custom)];
};
$gap = fn($px) => ['number' => $px, 'unit' => 'px', 'style' => $px . 'px'];

// Banner + images + title + intro
$S(100, 'design.background.image.breakpoint_base', "[breakdance_dynamic field='metabox_image_banner_image']");
$S(127, 'content.content.image', "[breakdance_dynamic field='post_featured_image']");
// Main-column title (128) removed 2026-09-23: the banner H1 already shows the title.
cura_bd_remove($t['root'], 128);
$in = $dyn('metabox_field_intro'); $S(129, 'content.content.text', $in['shortcode']); $S(129, 'content.content.text_dynamic_meta', $in['meta']); // Intro field (no Gutenberg)
$S(131, 'content.content.image', "[breakdance_dynamic field='metabox_image_detail_image']");

// Sidebar: services loop replaces the 9 static buttons (heading 115 stays)
$side = cura_bd_el('PostsLoop', ['content' => ['repeated_block' => ['global_block' => $blkLink], 'query' => ['query' => $query(['postTypes' => ['services']], "return ['post_type' => 'services', 'posts_per_page' => 20, 'orderby' => 'menu_order', 'order' => 'ASC'];")]],
  'design' => ['list' => ['layout' => 'list', 'space_between_items' => $gap(1)]]]);
cura_bd_reid($side, $t);
$d = &cura_bd_node($t['root'], 116); $d['children'] = array_values(array_filter($d['children'], fn($c) => $c['id'] == 115)); $d['children'][] = $side; unset($d);
$S(115, 'content.content.tags', 'h3'); // sidebar card title, not a page heading

// Highlights: Dynamic Data Loop over the cloneable group
$hl = cura_bd_el('DynamicDataLoop', ['content' => ['repeated_block' => ['global_block' => $blkHl], 'field' => ['repeater_field' => 'metabox_group_highlights']],
  'design' => ['list' => ['layout' => 'list', 'space_between_items' => $gap(20)]]]);
cura_bd_reid($hl, $t);
$g = &cura_bd_node($t['root'], 130); foreach ($g['children'] as $k => $c) if ($c['id'] == 132) $g['children'][$k] = $hl; unset($g);

// FAQs: loop of FAQ posts related to this service (MB relationship), accordion layout
$fq = cura_bd_el('PostsLoop', ['content' => ['repeated_block' => ['global_block' => $blkFaq], 'query' => ['query' => $query(['postTypes' => ['faqs']],
  "return ['post_type' => 'faqs', 'posts_per_page' => 20, 'orderby' => 'menu_order date', 'order' => 'ASC', 'relationship' => ['id' => 'faq_to_service', 'to' => get_queried_object_id()]];")]],
  'design' => ['list' => ['layout' => 'accordion', 'space_between_items' => $gap(10)]], 'settings' => ['advanced' => ['classes' => ['cura-faq-loop']]]]);
cura_bd_reid($fq, $t);
$m = &cura_bd_node($t['root'], 112); foreach ($m['children'] as $k => $c) if ($c['id'] == 133) $m['children'][$k] = $fq; unset($m);

// Drop the hidden pack leftovers (download box, team) from the template
foreach ([154, 138, 137, 139] as $id) cura_bd_remove($t['root'], $id);

// --- Template post ----------------------------------------------------------
$ex = get_posts(['post_type' => 'breakdance_template', 'title' => 'Single Service', 'post_status' => 'any', 'numberposts' => 1]);
$tid = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'breakdance_template', 'post_status' => 'publish', 'post_title' => 'Single Service']);
update_post_meta($tid, '_breakdance_template_settings', wp_slash(json_encode(json_encode(['type' => 'services', 'ruleGroups' => [], 'priority' => 20]))));
cura_bd_save($tid, ['tree_json_string' => ''], $t);
$log['template'] = $tid;
return $log;
