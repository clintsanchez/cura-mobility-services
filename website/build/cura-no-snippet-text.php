<?php
// Cura: remove the site's dependence on WPCodeBox snippet 1 (2026-09-26). Text that used [cura_phone]/[cura_email]
// shortcodes or the SEOPress {cura_phone} token is rewritten so it needs no code:
// - FAQ answers, confirmations, service area text: "Call us ..." (a call button sits beside each of these).
// - Policies: Phone/Email lines -> "Phone and email: see our Contact page"; accessibility statement points to the
//   contact details on the page (the Single Policy sidebar shows them dynamically).
// - SEO descriptions: phone sentence dropped or reworded.
// - Blog posts: number hard-coded again (tel:+12253630845 / (225) 363-0845); re-render + cura-blog-update.php when it changes.
// Breakdance-bound email/phone (header, footer, buttons, sidebars) stay dynamic via Meta Box; they never used the snippet.
// $DRY = true only reports. Idempotent.
$DRY = $DRY ?? true;
global $wpdb;
$NUM = '(225) 363-0845'; $TEL = '+12253630845';
$callUs = [
  'Call us at [cura_phone link=no]' => 'Call us', 'Call us at [cura_phone]' => 'Call us',
  'Call [cura_phone link=no]' => 'Call us', 'Call [cura_phone]' => 'Call us',
];
$policy = [
  'Call us at [cura_phone] and we will take your ride request over the phone' => 'Call us at the number in the contact details on this page and we will take your ride request over the phone',
];
$seo = [
  ' Call {cura_phone}.' => '',
  'Call {cura_phone} or send us a message' => 'Call or send us a message',
  'or call {cura_phone}.' => 'or by phone.',
  'Call {cura_phone} with' => 'Call us with',
];
$blog = ['tel:[cura_phone_tel]' => 'tel:' . $TEL, '[cura_phone link=no]' => $NUM, '[cura_phone]' => '<a href="tel:' . $TEL . '">' . $NUM . '</a>'];
$log = ['dry_run' => $DRY, 'meta' => [], 'content' => []];

// Meta (FAQ answers, confirmations, area text, SEO).
foreach ($wpdb->get_results("SELECT pm.meta_id, pm.post_id, pm.meta_key, pm.meta_value, p.post_type FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE p.post_type NOT IN ('revision','meta-box') AND pm.meta_key <> '_breakdance_data' AND (pm.meta_value LIKE '%[cura\\_%' OR pm.meta_value LIKE '%{cura\\_phone}%')", ARRAY_A) as $m) {
  $v = $m['meta_value'];
  $new = strpos($m['meta_key'], '_seopress_') === 0 ? strtr($v, $seo) : strtr($v, $callUs);
  if ($new === $v) { $log['meta'][] = "UNHANDLED {$m['post_id']} {$m['meta_key']}"; continue; }
  $log['meta'][] = "{$m['post_id']} {$m['post_type']} {$m['meta_key']}";
  if (!$DRY) $wpdb->update($wpdb->postmeta, ['meta_value' => $new], ['meta_id' => $m['meta_id']]);
}
// Post content (policies, FAQ, blog).
foreach ($wpdb->get_results("SELECT ID, post_type, post_content FROM {$wpdb->posts} WHERE post_type <> 'revision' AND post_status IN ('publish','private','draft') AND post_content LIKE '%[cura\\_%'", ARRAY_A) as $p) {
  $c = $p['post_content'];
  if ($p['post_type'] === 'post') {
    $new = strtr($c, $blog);
  } elseif ($p['post_type'] === 'policies') {
    $new = strtr($c, $policy);
    $new = preg_replace('#(<br\s*/?>\s*)?Email:\s*\[cura_email\]#', '', $new);
    $new = str_replace('Phone: [cura_phone]', 'Phone and email: see our <a href="/contact-us/">Contact page</a>', $new);
  } else {
    $new = strtr($c, $callUs);
  }
  if ($new === $c || strpos($new, '[cura_') !== false) { $log['content'][] = "CHECK {$p['ID']} {$p['post_type']}"; if ($new === $c) continue; }
  $log['content'][] = "{$p['ID']} {$p['post_type']}";
  if (!$DRY) { $wpdb->update($wpdb->posts, ['post_content' => $new], ['ID' => $p['ID']]); clean_post_cache($p['ID']); }
}
if (!$DRY) { wp_cache_flush(); if (class_exists('WpeCommon')) { \WpeCommon::purge_memcached(); \WpeCommon::purge_varnish_cache(); } }
$log['left_meta'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE p.post_type NOT IN ('revision','meta-box') AND pm.meta_key <> '_breakdance_data' AND (pm.meta_value LIKE '%[cura\\_%' OR pm.meta_value LIKE '%{cura\\_phone}%')");
$log['left_content'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type <> 'revision' AND post_status IN ('publish','private','draft') AND post_content LIKE '%[cura\\_%'");
return $log;
