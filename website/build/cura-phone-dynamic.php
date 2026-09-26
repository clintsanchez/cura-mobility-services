<?php
// Cura: make the phone number dynamic (Settings > Business info, option cura_business) everywhere (2026-09-25).
// Needs WPCodeBox snippet 1 sections "cura-business-info" + "cura-business-phone" ([cura_phone], [cura_phone_tel],
// rwmb_get_value shortcode pass, SEOPress {cura_phone} token).
// - Breakdance JSON (_breakdance_data): "(225) 363-0845" -> dynamic field phone_display; "tel:+12253630845" -> "tel:" +
//   dynamic field phone_tel. php_code props are reported, not changed (Code Blocks do not run shortcodes).
// - Post content (policies, FAQs, blog) + Meta Box fields (area_text, answer, conf_content, intro, ...):
//   linked number -> [cura_phone]; bare tel: -> tel:[cura_phone_tel]; bare number -> [cura_phone link=no].
// - SEOPress descriptions (title/OG/Twitter): number -> {cura_phone}.
// $DRY = true only counts. Idempotent. Skips revisions and the Meta Box field-group definitions.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$DRY = $DRY ?? true;
global $wpdb;
$NUM = '(225) 363-0845'; $TEL = '+12253630845';
$dDisp = cura_bd_dyn('metabox_field_cura_business_phone_display');
$dTel = cura_bd_dyn('metabox_field_cura_business_phone_tel');
$html = function ($s) use ($NUM, $TEL) {
  $s = str_replace('<a href="tel:' . $TEL . '">' . $NUM . '</a>', '[cura_phone]', $s);
  $s = str_replace('tel:' . $TEL, 'tel:[cura_phone_tel]', $s);
  return str_replace($NUM, '[cura_phone link=no]', $s);
};
$log = ['dry_run' => $DRY, 'breakdance' => [], 'content' => [], 'meta' => [], 'seo' => [], 'code_blocks' => []];

// 1. Breakdance trees.
foreach ($wpdb->get_col("SELECT pm.post_id FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE pm.meta_key = '_breakdance_data' AND p.post_type <> 'revision' AND (pm.meta_value LIKE '%363-0845%' OR pm.meta_value LIKE '%12253630845%')") as $pid) {
  [$j, $t] = cura_bd_load((int) $pid);
  $hits = 0;
  $walk = function (&$arr) use (&$walk, &$hits, &$log, $pid, $NUM, $TEL, $dDisp, $dTel) {
    foreach ($arr as $k => &$v) {
      if (is_array($v)) { $walk($v); continue; }
      if (!is_string($v) || (strpos($v, $NUM) === false && strpos($v, $TEL) === false)) continue;
      if ($k === 'php_code') { $log['code_blocks'][] = $pid; continue; }
      $new = str_replace('tel:' . $TEL, 'tel:' . $dTel['shortcode'], $v);
      $new = str_replace($TEL, $dTel['shortcode'], $new);
      $new = str_replace($NUM, $dDisp['shortcode'], $new);
      if ($new !== $v) { $v = $new; $hits++; }
    }
    unset($v);
  };
  $walk($t['root']);
  if ($hits) { $log['breakdance'][$pid] = $hits; if (!$DRY) cura_bd_save((int) $pid, $j, $t); }
}
// 2. Post content (non-revision).
foreach ($wpdb->get_results("SELECT ID, post_type, post_content FROM {$wpdb->posts} WHERE post_type NOT IN ('revision') AND post_status IN ('publish','private','draft') AND (post_content LIKE '%363-0845%' OR post_content LIKE '%12253630845%')", ARRAY_A) as $p) {
  $new = $html($p['post_content']);
  if ($new === $p['post_content']) continue;
  $log['content'][] = "{$p['ID']} {$p['post_type']}";
  if (!$DRY) { $wpdb->update($wpdb->posts, ['post_content' => $new], ['ID' => $p['ID']]); clean_post_cache($p['ID']); }
}
// 3. Meta Box fields + SEO.
$seoKeys = ['_seopress_titles_desc', '_seopress_social_fb_desc', '_seopress_social_twitter_desc'];
foreach ($wpdb->get_results("SELECT pm.meta_id, pm.post_id, pm.meta_key, pm.meta_value, p.post_type FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE p.post_type NOT IN ('revision','meta-box') AND pm.meta_key <> '_breakdance_data' AND (pm.meta_value LIKE '%363-0845%' OR pm.meta_value LIKE '%12253630845%')", ARRAY_A) as $m) {
  if (is_serialized($m['meta_value'])) { $log['meta'][] = "SKIP serialized {$m['post_id']} {$m['meta_key']}"; continue; }
  $new = in_array($m['meta_key'], $seoKeys, true) ? str_replace($NUM, '{cura_phone}', $m['meta_value']) : $html($m['meta_value']);
  if ($new === $m['meta_value']) continue;
  $log[in_array($m['meta_key'], $seoKeys, true) ? 'seo' : 'meta'][] = "{$m['post_id']} {$m['post_type']} {$m['meta_key']}";
  if (!$DRY) $wpdb->update($wpdb->postmeta, ['meta_value' => $new], ['meta_id' => $m['meta_id']]);
}
if (!$DRY) {
  wp_cache_flush();
  \Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles();
  \Breakdance\Render\generateCacheForGlobalSettings();
  ob_start();
  foreach ($wpdb->get_col("SELECT DISTINCT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_breakdance_data'") as $id) { try { \Breakdance\Render\generateCacheForPost((int) $id); } catch (\Throwable $e) {} }
  ob_end_clean();
  if (class_exists('WpeCommon')) { \WpeCommon::purge_memcached(); \WpeCommon::purge_varnish_cache(); }
}
$log['left'] = $wpdb->get_col("SELECT CONCAT(p.ID,' ',p.post_type,' ',pm.meta_key) FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE p.post_type NOT IN ('revision','meta-box') AND (pm.meta_value LIKE '%363-0845%' OR pm.meta_value LIKE '%12253630845%')");
$log['left_content'] = $wpdb->get_col("SELECT CONCAT(ID,' ',post_type) FROM {$wpdb->posts} WHERE post_type <> 'revision' AND post_status IN ('publish','private','draft') AND (post_content LIKE '%363-0845%' OR post_content LIKE '%12253630845%')");
return $log;
