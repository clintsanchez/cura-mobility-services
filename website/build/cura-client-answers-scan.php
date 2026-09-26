<?php
// Cura: scan for everything Michael's 2026-09-25 answers affect (CLIENT-ASKS.md). Read-only.
// Reports, per table/row/field, a short context snippet for:
//   email     : info@curamobility.org (business email is now curamobile88@gmail.com)
//   notify    : mveal72@yahoo.com in WS Form tables (form notifications)
//   coverage  : "Baton Rouge area", "nearby communities", "outside the Baton Rouge" (coverage is now all of Louisiana)
//   wheelchair: wheelchair / walker / scooter phrasing on the wheelchair service + FAQs (1 wheelchair-accessible van)
//   medicaid  : Medicaid / Healthy Louisiana / broker mentions (site is private pay; brokers later)
// Usage (Novamira execute-php): return require '<path>/cura-client-answers-scan.php';
global $wpdb;
$patterns = [
  'email' => 'info@curamobility.org',
  'notify' => 'mveal72@yahoo.com',
  'coverage' => ['Baton Rouge area', 'nearby communities', 'outside the Baton Rouge', 'Baton Rouge and nearby'],
  'wheelchair' => ['wheelchair-accessible', 'wheelchair accessible', 'ramp', 'lift', 'bring my own wheelchair', 'bring your own wheelchair'],
  'medicaid' => ['Medicaid', 'Healthy Louisiana', 'broker', 'MediTrans', 'Verida'],
];
$ctx = function ($hay, $needle) {
  $out = []; $off = 0;
  // Unescape JSON-escaped Breakdance text for readability.
  $plain = str_replace(['\\/', '\\"', '\\u2019'], ['/', '"', "'"], $hay);
  while (($p = stripos($plain, $needle, $off)) !== false && count($out) < 4) {
    $out[] = '…' . trim(preg_replace('/\s+/', ' ', wp_strip_all_tags(substr($plain, max(0, $p - 90), strlen($needle) + 180)))) . '…';
    $off = $p + strlen($needle);
  }
  return $out;
};
$where = function (array $needles, $col) use ($wpdb) {
  return '(' . implode(' OR ', array_map(fn($n) => $wpdb->prepare("`$col` LIKE %s", '%' . $wpdb->esc_like($n) . '%'), $needles)) . ')';
};
$report = [];
foreach ($patterns as $key => $needles) {
  $needles = (array) $needles;
  $hits = [];
  // posts
  foreach ($wpdb->get_results("SELECT ID, post_type, post_title, post_content, post_excerpt FROM {$wpdb->posts} WHERE post_status IN ('publish','private','draft') AND (" . $where($needles, 'post_content') . ' OR ' . $where($needles, 'post_excerpt') . ')', ARRAY_A) as $r)
    foreach ($needles as $n) foreach (['post_content', 'post_excerpt'] as $f) foreach ($ctx($r[$f], $n) as $c) $hits[] = "post {$r['ID']} {$r['post_type']} \"{$r['post_title']}\" [$f] $c";
  // postmeta
  foreach ($wpdb->get_results("SELECT pm.post_id, pm.meta_key, pm.meta_value, p.post_title, p.post_type FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE p.post_status IN ('publish','private','draft') AND " . $where($needles, 'meta_value'), ARRAY_A) as $r)
    foreach ($needles as $n) foreach ($ctx($r['meta_value'], $n) as $c) $hits[] = "meta {$r['post_id']} {$r['post_type']} \"{$r['post_title']}\" [{$r['meta_key']}] $c";
  // options
  foreach ($wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name NOT LIKE '\\_transient%' AND option_name NOT LIKE '\\_site\\_transient%' AND " . $where($needles, 'option_value'), ARRAY_A) as $r)
    foreach ($needles as $n) foreach ($ctx($r['option_value'], $n) as $c) $hits[] = "option [{$r['option_name']}] $c";
  // term meta + WS Form tables
  foreach ($wpdb->get_results("SELECT term_id, meta_key, meta_value FROM {$wpdb->termmeta} WHERE " . $where($needles, 'meta_value'), ARRAY_A) as $r)
    foreach ($needles as $n) foreach ($ctx($r['meta_value'], $n) as $c) $hits[] = "termmeta {$r['term_id']} [{$r['meta_key']}] $c";
  foreach ($wpdb->get_col("SHOW TABLES LIKE '{$wpdb->prefix}wsf%'") as $t) {
    foreach ($wpdb->get_results("SHOW COLUMNS FROM `$t`", ARRAY_A) as $col) {
      if (!preg_match('/char|text/i', $col['Type'])) continue;
      $c2 = $col['Field'];
      $n = (int) $wpdb->get_var("SELECT COUNT(*) FROM `$t` WHERE " . $where($needles, $c2));
      if ($n) $hits[] = "wsform $t.$c2: $n rows";
    }
  }
  $report[$key] = array_values(array_unique($hits));
}
$report['_counts'] = array_map('count', array_filter($report, 'is_array'));
return $report;
