<?php
// Cura: domain search-and-replace after the push to WP Engine (2026-09-24).
// Replaces the Local hostname with the WP Engine hostname in EVERY table and text column, serialization-safe:
// serialized values are unserialized, strings replaced recursively, then re-serialized (lengths stay valid).
// Swapping the host only (not the scheme) also covers JSON-escaped URLs ("https:\/\/cura-mobility.local") in
// Breakdance data, WS Form meta and the double-encoded Breakdance global settings.
// Skips wp_posts.guid (WordPress convention). Run with $DRY = true first; it only counts.
// Usage (Novamira execute-php on the WP Engine site): $DRY = true; return require '.../cura-search-replace.php';
// or paste the body. After a real run: Breakdance cache regen + WP Engine cache purge (see bottom).
$FROM = 'cura-mobility.local';
$TO = 'curamobility.wpenginepowered.com';
$DRY = $DRY ?? true;

global $wpdb;
$replaceDeep = function ($v) use (&$replaceDeep, $FROM, $TO) {
  if (is_string($v)) return str_replace($FROM, $TO, $v);
  if (is_array($v)) { foreach ($v as $k => $x) $v[$k] = $replaceDeep($x); return $v; }
  if ($v instanceof \stdClass) { foreach (get_object_vars($v) as $k => $x) $v->$k = $replaceDeep($x); return $v; }
  return $v; // other objects/scalars untouched
};
$hasIncomplete = function ($v) use (&$hasIncomplete) {
  if ($v instanceof \__PHP_Incomplete_Class) return true;
  if (is_array($v) || is_object($v)) foreach ((array) $v as $x) if ($hasIncomplete($x)) return true;
  return false;
};

$report = ['dry_run' => $DRY, 'tables' => [], 'skipped_incomplete' => []];
$like = '%' . $wpdb->esc_like($FROM) . '%';
foreach ($wpdb->get_col('SHOW TABLES') as $table) {
  $cols = $wpdb->get_results("SHOW COLUMNS FROM `$table`", ARRAY_A);
  $pk = null; $text = [];
  foreach ($cols as $c) {
    if ($c['Key'] === 'PRI' && $pk === null) $pk = $c['Field'];
    if (preg_match('/char|text|blob|json/i', $c['Type'])) $text[] = $c['Field'];
  }
  if (!$pk || !$text) continue;
  foreach ($text as $col) {
    if ($table === $wpdb->posts && $col === 'guid') continue;
    $rows = $wpdb->get_results($wpdb->prepare("SELECT `$pk` AS id, `$col` AS v FROM `$table` WHERE `$col` LIKE %s", $like), ARRAY_A);
    if (!$rows) continue;
    $changed = 0;
    foreach ($rows as $r) {
      $old = $r['v'];
      if (is_serialized($old)) {
        $data = @unserialize($old);
        if ($data === false && $old !== serialize(false)) { $report["skipped_incomplete"][] = "$table.$col#{$r["id"]} (unserialize failed; left as is)"; continue; }
        if ($hasIncomplete($data)) { $report['skipped_incomplete'][] = "$table.$col#{$r['id']}"; continue; }
        $new = serialize($replaceDeep($data));
      } else {
        $new = str_replace($FROM, $TO, $old);
      }
      if ($new === $old) continue;
      $changed++;
      if (!$DRY) $wpdb->update($table, [$col => $new], [$pk => $r['id']]);
    }
    if ($changed) $report['tables']["$table.$col"] = $changed;
  }
}

if (!$DRY) {
  wp_cache_flush();
  if (function_exists('Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles')) {
    \Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles();
    \Breakdance\Render\generateCacheForGlobalSettings();
    $ids = $wpdb->get_col("SELECT DISTINCT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_breakdance_data'");
    foreach ($ids as $id) { try { \Breakdance\Render\generateCacheForPost((int) $id); } catch (\Throwable $e) { $report['cache_errors'][] = "$id: " . $e->getMessage(); } }
    $report['breakdance_cache_regenerated'] = count($ids);
  }
  if (class_exists('WpeCommon')) {
    if (method_exists('WpeCommon', 'purge_memcached')) \WpeCommon::purge_memcached();
    if (method_exists('WpeCommon', 'purge_varnish_cache')) \WpeCommon::purge_varnish_cache();
    $report['wpe_cache_purged'] = true;
  }
}
$report['remaining'] = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", $like))
  + (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->options} WHERE option_value LIKE %s", $like));
$report['home'] = get_option('home');
$report['siteurl'] = get_option('siteurl');
return $report;
