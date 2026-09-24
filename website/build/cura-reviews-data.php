<?php
// Cura reviews, data pass. The 27 reviews supplied 2026-09-23 are SAMPLE placeholders:
// the headshots are synthetic (see the zip README). They go in the `sample` review category and
// the loops only show that category on the local environment. Idempotent (matched by title).
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$DIR = '/Users/clintsanchez/pCloud Drive/Documents/BlakSheep Creative/Clients/Cura Mobility Services/05-Photos/reviewers-SAMPLE-synthetic/';
$log = [];

// 1. Relationship: Review -> Service (mirrors the blueprint's faq_to_service, post 30).
$rel = ['id' => 'review_to_service', 'delete_data' => true, 'reciprocal' => true, 'from' => ['post_type' => 'review'], 'to' => ['post_type' => 'services']];
$ex = get_posts(['post_type' => 'mb-relationship', 'name' => 'review-to-service', 'post_status' => 'any', 'numberposts' => 1]);
$rid = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'mb-relationship', 'post_status' => 'publish', 'post_title' => 'Review to Service', 'post_name' => 'review-to-service']);
update_post_meta($rid, 'settings', $rel); update_post_meta($rid, 'relationship', $rel);
// Register now so this request can connect posts (MB registers on init from the post above).
if (function_exists('MB_Relationships_API') || class_exists('MB_Relationships_API')) {
  if (!MB_Relationships_API::get_relationship('review_to_service')) MB_Relationships_API::register($rel);
}
$log['relationship'] = $rid;

// 2. Sample category.
$term = term_exists('sample', 'review-categories') ?: wp_insert_term('Sample (placeholder)', 'review-categories', ['slug' => 'sample', 'description' => 'Placeholder reviews with synthetic headshots. Shown on the local site only. Delete before launch.']);
$tid = (int) (is_array($term) ? $term['term_id'] : $term);

// 3. Services by normalized title.
$norm = fn($s) => preg_replace('/[^a-z]/', '', strtolower($s));
$svc = []; foreach (get_posts(['post_type' => 'services', 'numberposts' => -1]) as $p) $svc[$norm($p->post_title)] = $p->ID;

$reviews = require __DIR__ . '/cura-reviews-list.php';
$out = [];
foreach ($reviews as $i => [$name, $service, $body, $file]) {
  $sid = $svc[$norm($service)] ?? null;
  if (!$sid) throw new Exception("no service for $service");
  $alt = "$name (sample reviewer portrait, synthetic)";
  $img = cura_upload($DIR . $file, $alt, $alt);
  if (is_wp_error($img)) throw new Exception($file . ': ' . $img->get_error_message());
  $ex = get_posts(['post_type' => 'review', 'title' => $name, 'post_status' => 'any', 'numberposts' => 1]);
  $arr = ['post_type' => 'review', 'post_status' => 'publish', 'post_title' => $name, 'menu_order' => $i + 1, 'post_author' => 1];
  if ($ex) $arr['ID'] = $ex[0]->ID;
  $id = wp_insert_post(wp_slash($arr), true);
  if (is_wp_error($id)) throw new Exception($id->get_error_message());
  update_post_meta($id, 'review_body', $body);
  update_post_meta($id, 'persons_name', $name);
  update_post_meta($id, 'source', 'Sample placeholder');
  update_post_meta($id, 'reviewer_avatar', $img);
  wp_set_object_terms($id, [$tid], 'review-categories');
  if (!MB_Relationships_API::has($id, $sid, 'review_to_service')) MB_Relationships_API::add($id, $sid, 'review_to_service');
  $out[] = $id;
}
$log['reviews'] = count($out);
return $log;
