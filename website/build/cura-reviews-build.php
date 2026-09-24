<?php
// Cura reviews, Breakdance pass: Review card block, Home reviews loop, per-service reviews on the
// Single Service template. Sample reviews render on the local environment only. Idempotent.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$log = [];
[$hj, $home] = cura_bd_load(67);
// Pack review-card element props (home 440-443), saved because the loop replaces those nodes.
$cardProps = json_decode(file_get_contents(__DIR__ . '/review-card-props.json'), true);
$p = fn($id) => $cardProps[(string) $id];
$bind = function ($props, $slug) { $d = cura_bd_dyn($slug); $props['content']['content']['text'] = $d['shortcode']; $props['content']['content']['text_dynamic_meta'] = $d['meta']; return $props; };

// Shared query pieces. Samples are excluded anywhere but the local site.
$sampleGuard = "(wp_get_environment_type() === 'local' ? [] : [['taxonomy' => 'review-categories', 'field' => 'slug', 'terms' => ['sample'], 'operator' => 'NOT IN']])";
$homeArgs = "['post_type' => 'review', 'posts_per_page' => 3, 'orderby' => 'rand', 'tax_query' => $sampleGuard]";
$svcArgs  = "['post_type' => 'review', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'order' => 'ASC', 'relationship' => ['id' => 'review_to_service', 'to' => get_queried_object_id()], 'tax_query' => $sampleGuard]";
$loopNode = function ($blk, $args) {
  return cura_bd_el('PostsLoop', ['content' => ['repeated_block' => ['global_block' => $blk], 'query' => ['query' => ['active' => 'php', 'text' => '', 'php' => "return $args;",
    'custom' => ['source' => 'post_types', 'postsPerPage' => 3, 'conditions' => [[[]]], 'totalPosts' => null, 'ignoreStickyPosts' => true, 'ignoreCurrentPost' => false, 'postTypes' => ['review'], 'orderBy' => 'menu_order', 'order' => 'ASC', 'date' => 'all', 'beforeDate' => null, 'afterDate' => null, 'offset' => null, 'acfField' => null, 'metaboxField' => null]]]],
    'design' => ['list' => ['layout' => 'grid', 'items_per_row' => ['breakpoint_base' => 3, 'breakpoint_tablet_landscape' => 2], 'one_item_at' => 'breakpoint_phone_landscape', 'space_between_items' => ['number' => 32, 'unit' => 'px', 'style' => '32px']]]]);
};
// Hides the whole section when the query finds nothing (e.g. live site before real reviews exist).
$guard = fn($args, $sectionClass) => cura_bd_el('CodeBlock', ['content' => ['content' => ['php_code' => "<?php if (!(new WP_Query(array_merge($args, ['fields' => 'ids'])))->have_posts()) echo '<style>.$sectionClass{display:none}</style>'; ?>"]]]);

// 1. Review card global block (pack column 434 children, bound to review fields).
$img = $p(440); $img['content']['content']['image'] = "[breakdance_dynamic field='metabox_image_reviewer_avatar']";
// Visible "Sample review" tag removed at Clint's request 2026-09-23 (samples stay local-only via $sampleGuard).
$svcHead = $bind($p(443), 'post_title'); $svcHead['settings']['advanced']['classes'] = ['cura-loop-flush'];
$svcBlk = cura_bd_block('Review service name', [['id' => 0, 'data' => ['type' => 'EssentialElements\\Heading', 'properties' => $svcHead], 'children' => []]]);
$svcLine = cura_bd_el('PostsLoop', ['content' => ['repeated_block' => ['global_block' => $svcBlk], 'query' => ['query' => ['active' => 'php', 'text' => '',
  'php' => "return ['post_type' => 'services', 'posts_per_page' => 1, 'relationship' => ['id' => 'review_to_service', 'from' => get_the_ID()]];",
  'custom' => ['source' => 'post_types', 'postsPerPage' => 1, 'conditions' => [[[]]], 'totalPosts' => null, 'ignoreStickyPosts' => true, 'ignoreCurrentPost' => false, 'postTypes' => ['services'], 'orderBy' => 'menu_order', 'order' => 'ASC', 'date' => 'all', 'beforeDate' => null, 'afterDate' => null, 'offset' => null, 'acfField' => null, 'metaboxField' => null]]]],
  'design' => ['list' => ['layout' => 'list', 'space_between_items' => ['number' => 0, 'unit' => 'px', 'style' => '0px']]], 'settings' => ['advanced' => ['classes' => ['cura-review-service-loop']]]]);
// Rating row: platform icon (Meta Box icon field; its formatter returns inline SVG, Breakdance's field only the class)
// + Breakdance Star Rating bound to number_of_stars, labelled with the source.
$stars = cura_bd_dyn('metabox_field_number_of_stars'); $srcDyn = cura_bd_dyn('metabox_field_source');
$rating = cura_bd_el('Div', ['settings' => ['advanced' => ['classes' => ['cura-review-rating']]]], [
  cura_bd_el('CodeBlock', ['content' => ['content' => ['php_code' => "<?php \$i = rwmb_the_value('review_platform_icon', [], get_the_ID(), false); if (\$i) echo '<span class=\"cura-review-platform\" aria-hidden=\"true\">' . \$i . '</span>'; ?>"]]]),
  cura_bd_el('StarRating', ['content' => ['components' => ['stars_max' => '5', 'stars' => '5', 'icon_type' => 'fontawesome', 'show_label' => true,
    'rating' => $stars['shortcode'], 'rating_dynamic_meta' => $stars['meta'], 'label_text' => $srcDyn['shortcode'], 'label_text_dynamic_meta' => $srcDyn['meta']]]]),
]);
$card = cura_bd_el('Div', ['settings' => ['advanced' => ['classes' => ['cura-card', 'cura-review-card']]]], [
  ['id' => 0, 'data' => ['type' => 'EssentialElements\\Image', 'properties' => $img], 'children' => []],
  $rating,
  ['id' => 0, 'data' => ['type' => 'EssentialElements\\Text', 'properties' => $bind($p(441), 'metabox_field_review_body')], 'children' => []],
  ['id' => 0, 'data' => ['type' => 'EssentialElements\\Heading', 'properties' => $bind($p(442), 'metabox_field_persons_name')], 'children' => []],
  // Service line: nested Post Loop of the service(s) connected to this review (Meta Box relationship),
  // repeating a block whose Heading is bound to post_title. Breakdance's own relationship field
  // returns empty because Meta Box stores relationship values as an array.
  $svcLine,
]);
$blk = cura_bd_block('Review card', [$card]);
$log['block'] = $blk;

// 2. Home reviews section 415: unhide, Cura copy, loop in place of the 3 static columns.
$S = function (&$t, $id, $path, $v) { if (!cura_bd_set($t, $id, $path, $v)) throw new Exception("no $id"); };
$n = &cura_bd_node($home['root'], 415); unset($n['data']['properties']['settings']['advanced']['draft']); unset($n);
$S($home, 419, 'content.content.text', 'Rider reviews');
$S($home, 462, 'content.content.text', 'What riders say');
$S($home, 421, 'content.content.text', 'Kind words from riders and families who ride with us.');
$loop = $loopNode($blk, $homeArgs); cura_bd_reid($loop, $home);
$g = $guard($homeArgs, 'bde-section-67-415'); cura_bd_reid($g, $home);
$d = &cura_bd_node($home['root'], 432); $keepIds = array_column($d['children'], 'id'); $d['children'] = [$g, $loop]; unset($d);
cura_bd_save(67, $hj, $home);
$section = cura_bd_node($home['root'], 415); // cleaned section, reused below

// 3. Single Service template: the same section after the main content, filtered to this service.
$tpl = get_posts(['post_type' => 'breakdance_template', 'title' => 'Single Service', 'numberposts' => 1])[0]->ID;
[$tj, $tt] = cura_bd_load($tpl);
$tt['root']['children'] = array_values(array_filter($tt['root']['children'], fn($c) => empty($c['data']['properties']['settings']['advanced']['classes']) || !in_array('cura-reviews-section', $c['data']['properties']['settings']['advanced']['classes'])));
$sec = $section; cura_bd_reid($sec, $tt);
$sec['data']['properties']['settings']['advanced']['classes'] = ['cura-reviews-section'];
$sid = $sec['id'];
$swap = function (&$node) use (&$swap, $blk, $svcArgs, $loopNode, $guard, $sid, &$tt, $tpl) {
  if (empty($node['children'])) return;
  foreach ($node['children'] as &$c) {
    $type = $c['data']['type'] ?? '';
    if ($type === 'EssentialElements\\PostsLoop') { $new = $loopNode($blk, $svcArgs); $new['id'] = $c['id']; $c = $new; }
    elseif ($type === 'EssentialElements\\CodeBlock') { $new = $guard($svcArgs, "bde-section-$tpl-$sid"); $new['id'] = $c['id']; $c = $new; }
    else $swap($c);
  }
  unset($c);
};
$swap($sec);
$idx = null; foreach ($tt['root']['children'] as $k => $c) if ($c['id'] == 108) $idx = $k;
array_splice($tt['root']['children'], $idx + 1, 0, [$sec]);
cura_bd_save($tpl, $tj, $tt);
$log['template_section'] = $sid;

// 4. Styles.
$gs = json_decode(json_decode(get_option('breakdance_global_settings_json_string')), true); $ss = $gs['settings']['code']['stylesheets'];
$css = ".cura-review-card{display:flex;flex-direction:column;align-items:center;text-align:center}\n.cura-sample-tag{display:inline-block;margin-bottom:12px;padding:3px 10px;border-radius:999px;background:#FFF4D6;color:#6B4400;font-size:12px;font-weight:700;letter-spacing:.04em;text-transform:uppercase}\n.cura-review-card .bde-text,.cura-review-card .bde-heading,.cura-review-card .bde-code-block{text-align:center;width:100%}\n.cura-review-card .bde-image{margin-inline:auto}\n.cura-review-card .cura-sample-tag{display:table;margin:0 auto 12px}\n.cura-review-service-loop{width:100%}\n.breakdance .cura-review-card .cura-review-rating{display:flex;flex-direction:row;align-items:center;justify-content:center;gap:8px;width:auto;margin:0 auto 15px}\n.breakdance .cura-review-card .cura-review-rating .bde-code-block{width:auto}\n.breakdance .cura-review-rating .bde-star-rating{display:flex;flex-direction:row;align-items:center;gap:8px}\n.breakdance .cura-review-rating .bde-star-rating__label{font-size:15px;font-weight:600;color:#02265A}\n.breakdance .cura-review-rating .bde-star-rating__wrapper svg{width:18px;height:18px}\n.cura-review-platform{display:flex}\n.cura-review-platform svg{width:18px;height:18px;fill:#02265A}\n.cura-reviews-empty{text-align:center;font-size:18px;max-width:640px;margin:0 auto}";
$pos = array_search('Cura: reviews', array_column($ss, 'name')); $e = ['name' => 'Cura: reviews', 'code' => $css];
if ($pos === false) $ss[] = $e; else $ss[$pos] = $e;
$gs['settings']['code']['stylesheets'] = $ss; \Breakdance\Data\save_global_settings(json_encode(['settings' => $gs['settings']]));
\Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles(); \Breakdance\Render\generateCacheForGlobalSettings();
foreach ([67, $blk, $tpl, 182, 1383, 1384, 1385, 1386, 180, 186, 204, 206, 208, 176, 244] as $id) \Breakdance\Render\generateCacheForPost($id);
return $log;
