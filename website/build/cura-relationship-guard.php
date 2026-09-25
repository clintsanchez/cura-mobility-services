<?php
// Cura: guard the Meta Box relationship loops against an empty ID (2026-09-24).
// WP Engine error log: "SQL syntax ... mbr.to IN ()" from wp_ajax_breakdance_regenerate_post_cache. When Breakdance
// renders a template or block for its cache there is no service/review in context, the relationship ID is 0 and
// MB Relationships builds "IN ()". Each loop now returns an empty query (post__in [0]) when the ID is missing.
// Loops: Single Service 1387 (#169 FAQs, #269 reviews) and Review card block 1454 (#107 service name). Idempotent.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$fixes = [
  1387 => [
    169 => "\$id = (int) get_queried_object_id(); if (!\$id || get_post_type(\$id) !== 'services') return ['post_type' => 'faqs', 'post__in' => [0]]; return ['post_type' => 'faqs', 'posts_per_page' => 20, 'orderby' => 'menu_order date', 'order' => 'ASC', 'relationship' => ['id' => 'faq_to_service', 'to' => \$id]];",
    269 => "\$id = (int) get_queried_object_id(); if (!\$id || get_post_type(\$id) !== 'services') return ['post_type' => 'review', 'post__in' => [0]]; return ['post_type' => 'review', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'order' => 'ASC', 'relationship' => ['id' => 'review_to_service', 'to' => \$id], 'tax_query' => (wp_get_environment_type() === 'local' ? [] : [['taxonomy' => 'review-categories', 'field' => 'slug', 'terms' => ['sample'], 'operator' => 'NOT IN']])];",
  ],
  1454 => [
    107 => "\$id = (int) get_the_ID(); if (!\$id || get_post_type(\$id) !== 'review') return ['post_type' => 'services', 'post__in' => [0]]; return ['post_type' => 'services', 'posts_per_page' => 1, 'relationship' => ['id' => 'review_to_service', 'from' => \$id]];",
  ],
];
$log = [];
foreach ($fixes as $pid => $nodes) {
  [$j, $t] = cura_bd_load($pid);
  foreach ($nodes as $nid => $php) {
    $n = &cura_bd_node($t['root'], $nid);
    if ($n === null) { $log[] = "$pid#$nid missing"; unset($n); continue; }
    $n['data']['properties']['content']['query']['query']['php'] = $php;
    $n['data']['properties']['content']['query']['query']['active'] = 'php';
    $log[] = "$pid#$nid guarded";
    unset($n);
  }
  cura_bd_save($pid, $j, $t);
}
return $log;
