<?php
// Cura: Reviews page (/reviews/) from the Pixels Cab "Testimonial" page (202). Same banner + section
// structure; the 3 static rows become one Post Loop of all reviews using the Review card block.
// Sample reviews render on the local environment only. Idempotent.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$PID = 202; $log = [];
$W = '/Users/clintsanchez/pCloud Drive/Documents/BlakSheep Creative/Clients/Cura Mobility Services/05-Photos/web/';
[$j, $t] = cura_bd_load($PID);
$card = get_posts(['post_type' => 'breakdance_block', 'title' => 'Review card', 'numberposts' => 1])[0]->ID;

// Banner photo (page title + breadcrumb are already dynamic).
$alt = 'Senior woman in glasses smiling from the back seat window of a car';
cura_bd_set($t, 100, 'design.background.image.breakpoint_base', cura_bd_image(cura_upload($W . 'home-rider/senior-woman-smiling-in-back-seat-window.webp', $alt, $alt)));

// "When empty" block: shown instead of the grid when no reviews qualify (live site before real reviews).
$empty = cura_bd_block('Reviews empty', [cura_bd_el('Text', ['content' => ['content' => ['text' => 'Rider reviews are on the way. Have you ridden with us? We would love to hear how it went. Call or text <a href="tel:+12253630845">(225) 363-0845</a>.']], 'settings' => ['advanced' => ['classes' => ['cura-reviews-empty']]]])]);

$args = "['post_type' => 'review', 'posts_per_page' => 60, 'orderby' => ['date' => 'DESC', 'menu_order' => 'ASC'], 'tax_query' => (wp_get_environment_type() === 'local' ? [] : [['taxonomy' => 'review-categories', 'field' => 'slug', 'terms' => ['sample'], 'operator' => 'NOT IN']])]";
$loop = cura_bd_el('PostsLoop', ['content' => ['repeated_block' => ['global_block' => $card, 'advanced' => ['when_empty' => $empty]], 'query' => ['query' => ['active' => 'php', 'text' => '', 'php' => "return $args;",
  'custom' => ['source' => 'post_types', 'postsPerPage' => 60, 'conditions' => [[[]]], 'totalPosts' => null, 'ignoreStickyPosts' => true, 'ignoreCurrentPost' => false, 'postTypes' => ['review'], 'orderBy' => 'date', 'order' => 'DESC', 'date' => 'all', 'beforeDate' => null, 'afterDate' => null, 'offset' => null, 'acfField' => null, 'metaboxField' => null]]]],
  'design' => ['list' => ['layout' => 'grid', 'items_per_row' => ['breakpoint_base' => 3, 'breakpoint_tablet_landscape' => 2], 'one_item_at' => 'breakpoint_phone_landscape', 'space_between_items' => ['number' => 32, 'unit' => 'px', 'style' => '32px']]]]);
cura_bd_reid($loop, $t);

// Section 108: keep the first row's container (Div 115, pack width + entrance animation), swap its
// Columns for the loop, and drop the other two static rows.
$sec = &cura_bd_node($t['root'], 108);
$first = null;
foreach ($sec['children'] as $k => $c) { if ($first === null) { $first = $k; continue; } }
$sec['children'] = [$sec['children'][$first]];
$sec['children'][0]['children'] = [$loop];
unset($sec);
cura_bd_save($PID, $j, $t);

// Publish as /reviews/.
wp_update_post(['ID' => $PID, 'post_title' => 'Reviews', 'post_name' => 'reviews', 'post_status' => 'publish']);

// Primary menu: add Reviews after FAQs (once).
$items = wp_get_nav_menu_items(35); $has = false; $faqPos = 0;
foreach ($items as $it) { if ((int) $it->object_id === $PID) $has = true; if ((int) $it->object_id === 204) $faqPos = $it->menu_order; }
if (!$has) {
  foreach ($items as $it) if ($it->menu_order > $faqPos) wp_update_nav_menu_item(35, $it->ID, ['menu-item-title' => $it->title, 'menu-item-object-id' => $it->object_id, 'menu-item-object' => $it->object, 'menu-item-type' => $it->type, 'menu-item-url' => $it->url, 'menu-item-position' => $it->menu_order + 1, 'menu-item-status' => 'publish']);
  wp_update_nav_menu_item(35, 0, ['menu-item-title' => 'Reviews', 'menu-item-object-id' => $PID, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-position' => $faqPos + 1, 'menu-item-status' => 'publish']);
}
$log['menu'] = array_map(fn($i) => $i->title, wp_get_nav_menu_items(35));

// Styles for the empty note.
$gs = json_decode(json_decode(get_option('breakdance_global_settings_json_string')), true); $ss = $gs['settings']['code']['stylesheets'];
foreach ($ss as &$e) if ($e['name'] === 'Cura: reviews' && strpos($e['code'], 'cura-reviews-empty') === false) $e['code'] .= "\n.cura-reviews-empty{text-align:center;font-size:18px;max-width:640px;margin:0 auto}";
unset($e);
$gs['settings']['code']['stylesheets'] = $ss; \Breakdance\Data\save_global_settings(json_encode(['settings' => $gs['settings']]));
\Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles(); \Breakdance\Render\generateCacheForGlobalSettings();
foreach ([$PID, $card, $empty, 67, 176, 244, 180, 182, 186, 204, 206, 208, 1383, 1384, 1385, 1386, 1387, 1454, 1456] as $id) \Breakdance\Render\generateCacheForPost($id);
$log['url'] = get_permalink($PID); $log['empty_block'] = $empty;
return $log;
