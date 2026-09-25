<?php
// Cura Resources (blog) archive, 2026-09-24.
// - "Resources" page (slug resources) set as the posts page (page_for_posts); 9 posts per page (3-column grid).
// - "Post card" global block: clone of the Service card (1383) with the featured image + category eyebrow in place
//   of the icon, and a "Read article" button. Same .cura-card class, so the pinned-button CSS applies.
// - "Resources empty" block for the loop's when_empty state.
// - Post Archive template 454 (covers the posts page and category archives): hero + breadcrumb use Archive Title;
//   the pack Postslist is replaced by a Posts Loop (main query, number pagination) laid out like the Services page.
// Archive title on the posts page + no "Category:" prefix comes from WPCodeBox snippet 1 (see cura-resources-snippet).
// Idempotent.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$log = [];

// 1. Resources page -> posts page.
$pg = get_page_by_path('resources');
$pid = $pg ? $pg->ID : wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Resources', 'post_name' => 'resources', 'post_author' => 1]);
update_option('page_for_posts', $pid);
update_option('posts_per_page', 9);
wp_update_post(['ID' => $pid, 'post_excerpt' => 'Practical guides for riders, families and caregivers planning medical rides in the Baton Rouge area.']);
foreach ([
  '_seopress_titles_title' => 'Resources for riders and caregivers | Cura Mobility Services',
  '_seopress_titles_desc' => 'Guides for families and caregivers in Baton Rouge: planning medical rides for a parent, getting home from the hospital and helping a loved one with a walker or wheelchair.',
  '_seopress_social_fb_title' => 'Resources for riders and caregivers',
  '_seopress_social_fb_desc' => 'Practical guides for planning medical rides, hospital discharges and appointments for someone you care for.',
  '_seopress_social_twitter_title' => 'Resources for riders and caregivers',
  '_seopress_social_twitter_desc' => 'Practical guides for planning medical rides, hospital discharges and appointments for someone you care for.',
] as $k => $v) update_post_meta($pid, $k, $v);
$log['resources_page'] = $pid;

// Helper: create/update a global block by title.
$block = function ($title, $j, $tree) {
  $ex = get_posts(['post_type' => 'breakdance_block', 'title' => $title, 'post_status' => 'any', 'numberposts' => 1]);
  $id = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'breakdance_block', 'post_status' => 'publish', 'post_title' => $title]);
  cura_bd_save($id, $j, $tree);
  return $id;
};

// 2. Post card (from Service card 1383).
[$j, $t] = cura_bd_load(1383);
$card = &$t['root']['children'][0];
$card['data']['properties']['settings']['advanced']['classes'] = ['cura-card', 'cura-post-card'];
foreach ($card['children'] as &$c) {
  if ($c['data']['type'] === 'EssentialElements\\CodeBlock') {
    $c['data']['properties']['content']['content']['php_code'] = '<?php $id = get_the_ID(); '
      . 'if (has_post_thumbnail($id)) echo \'<a class="cura-post-card-thumb" href="\' . esc_url(get_permalink($id)) . \'" tabindex="-1" aria-hidden="true">\' . get_the_post_thumbnail($id, "medium_large", ["alt" => ""]) . \'</a>\'; '
      . '$cat = get_the_category($id); if ($cat) echo \'<p class="cura-post-card-eyebrow">\' . esc_html($cat[0]->name) . \'</p>\'; ?>';
  }
  if ($c['data']['type'] === 'EssentialElements\\IconBox') $c['data']['properties']['content']['content']['button']['text'] = 'Read article';
}
unset($c, $card);
$cardId = $block('Post card', $j, $t);
$log['post_card_block'] = $cardId;

// 3. Empty state (from Reviews empty 1485).
[$j, $t] = cura_bd_load(1485);
$t['root']['children'][0]['data']['properties']['content']['content']['text'] = 'New guides for riders and caregivers are on the way. Have a question about a ride? Call <a href="tel:+12253630845">(225) 363-0845</a>.';
$t['root']['children'][0]['data']['properties']['settings']['advanced']['classes'] = ['cura-reviews-empty', 'cura-resources-empty'];
$emptyId = $block('Resources empty', $j, $t);
$log['empty_block'] = $emptyId;

// 4. Template 454.
[$j, $t] = cura_bd_load(454);
$dyn = cura_bd_dyn('archive_title');
foreach ([104, 107] as $nid) {
  $n = &cura_bd_node($t['root'], $nid);
  $n['data']['properties']['content']['content']['text'] = $dyn['shortcode'];
  $n['data']['properties']['content']['content']['text_dynamic_meta'] = $dyn['meta'];
  unset($n);
}
// Loop section: same structure as the Services page (Section 108 > Div > Posts Loop).
[, $svc] = cura_bd_load(182);
$div = cura_bd_node($svc['root'], 115);
cura_bd_reid($div, $t);
$loop = &$div['children'][0];
$loop['data']['properties']['content']['repeated_block'] = ['global_block' => $cardId, 'advanced' => ['when_empty' => $emptyId]];
unset($loop['data']['properties']['content']['query']); // no custom query = the archive's main query
$loop['data']['properties']['content']['pagination'] = ['pagination' => 'numbers'];
$loop['data']['properties']['settings']['advanced']['classes'] = ['cura-post-loop'];
unset($loop);
$sec = &cura_bd_node($t['root'], 108);
$sec['children'] = [$div];
unset($sec);
cura_bd_save(454, $j, $t);
$log['template'] = 454;

return $log;
