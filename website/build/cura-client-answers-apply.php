<?php
// Cura: apply Michael's 2026-09-25 answers (CLIENT-ASKS.md), step 1. $DRY = true reports only.
// 1. Email info@curamobility.org -> curamobile88@gmail.com everywhere (posts, postmeta incl. Breakdance JSON).
// 2. WS Form notifications mveal72@yahoo.com -> curamobile88@gmail.com (wsf tables only; serialization-safe).
// 3. Coverage: "Baton Rouge area" wording -> Baton Rouge-based, statewide (ordered phrase rules; blog posts excluded,
//    they keep their Baton Rouge local hooks).
// 4. Wheelchair: one wheelchair-accessible van (intro, highlight, subheading, SEO description, 3 FAQs).
// 5. Private pay: Medicaid FAQ gains a private-pay line.
// Then Breakdance cache rebuild (+ WP Engine cache purge when present). Idempotent.
$DRY = $DRY ?? true;
global $wpdb;
$EMAIL_OLD = 'info@curamobility.org'; $EMAIL_NEW = 'curamobile88@gmail.com';
$NOTIFY_OLD = 'mveal72@yahoo.com';
$TEL = '<a href="tel:+12253630845">(225) 363-0845</a>';

// Ordered: most specific first.
$rules = [
  ['We serve Baton Rouge and nearby communities. If you are not sure we cover your area, give us a call.', 'We are based in Baton Rouge and give rides across the entire state of Louisiana. Call us with your pickup and destination, and we will plan the ride with you.'],
  ['We pick riders up across Baton Rouge and nearby communities and drive them to specialists and hospitals farther away', 'We pick riders up anywhere in Louisiana and drive them to specialists and hospitals farther from home'],
  ['Rides from the Baton Rouge area to specialists and hospitals farther away', 'Rides to specialists and hospitals anywhere in Louisiana'],
  ['Long-distance trips from the Baton Rouge area', 'Long-distance trips across Louisiana'],
  ['Serving the Baton Rouge area', 'Serving all of Louisiana'],
  ['We serve the Baton Rouge area', 'We serve all of Louisiana'],
  ['outside the Baton Rouge area', 'farther from home, anywhere in Louisiana'],
  ['Baton Rouge and nearby communities', 'Baton Rouge and all of Louisiana'],
  ['across the Baton Rouge area', 'across Louisiana'],
  ['in the Baton Rouge area', 'in Baton Rouge and across Louisiana'],
];
$regex = [
  // area_text: statewide, so "Not sure we cover ...? Call X and ask." becomes a plain call to plan.
  ['#Not sure we cover your [^?]+\? Call (<a href="tel:\+12253630845">\(225\) 363-0845</a>) and ask\.#', 'Call $1 to plan your ride.'],
];
$applyRules = function ($s, $metaKey = '') use ($rules, $regex) {
  if ($metaKey === 'area_heading') $s = preg_replace('/ across the Baton Rouge area$/', ' from Baton Rouge across Louisiana', $s);
  foreach ($rules as [$a, $b]) $s = str_replace($a, $b, $s);
  foreach ($regex as [$p, $r]) $s = preg_replace($p, $r, $s);
  return $s;
};
$deep = function ($v, callable $fn) use (&$deep) {
  if (is_string($v)) return $fn($v);
  if (is_array($v)) { foreach ($v as $k => $x) $v[$k] = $deep($x, $fn); return $v; }
  if ($v instanceof \stdClass) { foreach (get_object_vars($v) as $k => $x) $v->$k = $deep($x, $fn); return $v; }
  return $v;
};
$transform = function ($raw, callable $fn) use ($deep) {
  if (is_serialized($raw)) { $d = @unserialize($raw); if ($d === false && $raw !== serialize(false)) return $raw; return serialize($deep($d, $fn)); }
  return $fn($raw);
};
$log = ['dry_run' => $DRY, 'posts' => 0, 'meta' => 0, 'wsform' => 0, 'changed' => [], 'overrides' => []];

// Posts (content + excerpt), not blog posts.
foreach ($wpdb->get_results("SELECT ID, post_type, post_title, post_content, post_excerpt FROM {$wpdb->posts} WHERE post_status IN ('publish','private','draft') AND post_type NOT IN ('post','revision','attachment','nav_menu_item')", ARRAY_A) as $p) {
  $upd = [];
  foreach (['post_content', 'post_excerpt'] as $f) {
    $new = $applyRules(str_replace($EMAIL_OLD, $EMAIL_NEW, $p[$f]));
    if ($new !== $p[$f]) $upd[$f] = $new;
  }
  if ($upd) { $log['posts']++; $log['changed'][] = "post {$p['ID']} {$p['post_type']} \"{$p['post_title']}\": " . implode(',', array_keys($upd)); if (!$DRY) $wpdb->update($wpdb->posts, $upd, ['ID' => $p['ID']]); }
}
// Postmeta on non-blog posts (Breakdance JSON, SEOPress, Meta Box fields). Skip revisions and the field-group definition.
foreach ($wpdb->get_results("SELECT pm.meta_id, pm.post_id, pm.meta_key, pm.meta_value, p.post_type, p.post_title FROM {$wpdb->postmeta} pm JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE p.post_status IN ('publish','private','draft') AND p.post_type NOT IN ('post','revision','meta-box') AND (pm.meta_value LIKE '%Baton Rouge%' OR pm.meta_value LIKE '%" . esc_sql($EMAIL_OLD) . "%')", ARRAY_A) as $m) {
  $new = $transform($m['meta_value'], fn($s) => $applyRules(str_replace($EMAIL_OLD, $EMAIL_NEW, $s), $m['meta_key']));
  if ($new === $m['meta_value']) continue;
  if ($m['meta_key'] === '_breakdance_data') { $j = json_decode($new, true); if (!is_array($j) || json_decode($j['tree_json_string'] ?? 'null', true) === null) { $log['changed'][] = "SKIP invalid JSON {$m['post_id']}"; continue; } }
  $log['meta']++; $log['changed'][] = "meta {$m['post_id']} {$m['post_type']} \"{$m['post_title']}\" [{$m['meta_key']}]";
  if (!$DRY) $wpdb->update($wpdb->postmeta, ['meta_value' => $new], ['meta_id' => $m['meta_id']]);
}
// WS Form notification recipients.
foreach ($wpdb->get_col("SHOW TABLES LIKE '{$wpdb->prefix}wsf%'") as $t) {
  $pk = null; $cols = [];
  foreach ($wpdb->get_results("SHOW COLUMNS FROM `$t`", ARRAY_A) as $c) { if ($c['Key'] === 'PRI' && !$pk) $pk = $c['Field']; if (preg_match('/char|text/i', $c['Type'])) $cols[] = $c['Field']; }
  if (!$pk) continue;
  foreach ($cols as $c) foreach ($wpdb->get_results($wpdb->prepare("SELECT `$pk` AS id, `$c` AS v FROM `$t` WHERE `$c` LIKE %s", '%' . $wpdb->esc_like($NOTIFY_OLD) . '%'), ARRAY_A) as $r) {
    $new = $transform($r['v'], fn($s) => str_replace($NOTIFY_OLD, $EMAIL_NEW, $s));
    if ($new === $r['v']) continue;
    $log['wsform']++;
    if (!$DRY) $wpdb->update($t, [$c => $new], [$pk => $r['id']]);
  }
}

// Field-level overrides (wheelchair van, private pay).
$faqSet = function ($id, $answer) use ($wpdb, $DRY, &$log) {
  $log['overrides'][] = "faq $id";
  if ($DRY) return;
  update_post_meta($id, 'answer', $answer);
  if (trim(wp_strip_all_tags(get_post_field('post_content', $id))) !== '') $wpdb->update($wpdb->posts, ['post_content' => '<!-- wp:paragraph --><p>' . $answer . '</p><!-- /wp:paragraph -->'], ['ID' => $id]);
};
$w = get_page_by_path('wheelchair-transportation', OBJECT, 'services');
if ($w) {
  $intro = get_post_meta($w->ID, 'intro', true);
  $vanP = '<p>We have a wheelchair-accessible van for riders who stay in their wheelchair for the trip. It is one van, so please book as early as you can.</p>';
  if (strpos($intro, 'wheelchair-accessible van') === false) {
    $newIntro = preg_replace('#(<p>Tell us about your mobility needs)#', $vanP . "\n\n$1", $intro, 1, $n);
    if (!$n) $newIntro = $intro . "\n\n" . $vanP;
    $log['overrides'][] = 'wheelchair intro';
    if (!$DRY) update_post_meta($w->ID, 'intro', $newIntro);
  }
  $hl = get_post_meta($w->ID, 'highlights', true);
  if (is_array($hl)) {
    $hl2 = $deep($hl, fn($s) => $s === 'Rides for wheelchair, walker and scooter users' ? 'A wheelchair-accessible van' : $s);
    if ($hl2 !== $hl) { $log['overrides'][] = 'wheelchair highlight'; if (!$DRY) update_post_meta($w->ID, 'highlights', $hl2); }
  }
  $log['overrides'][] = 'wheelchair subheading + SEO description';
  if (!$DRY) {
    update_post_meta($w->ID, 'hero_subhead', 'Rides in a wheelchair-accessible van, with patient, hands-on help for people who use a wheelchair, walker or scooter.');
    update_post_meta($w->ID, '_seopress_titles_desc', 'Wheelchair-accessible van rides from Baton Rouge across Louisiana, with hands-on help for wheelchair, walker and scooter users and a clear price before you book.');
  }
}
$faqSet(1347, 'Yes, please bring your own wheelchair. Our wheelchair-accessible van lets you stay seated in it for the ride. Tell us about it when you book so we can plan the pickup.');
$faqSet(1377, 'Yes. We have a wheelchair-accessible van and drivers who give patient, hands-on help from your door to your seat. It is one van, so please book early and tell us about your wheelchair, walker or scooter when you call.');
$faqSet(1380, 'Louisiana Medicaid members usually arrange rides through their health plan. Call the member services number on the back of your card to learn what your plan covers. Cura Mobility Services is a private-pay ride service: you pay us directly, and you get a clear price before you book.');

if (!$DRY) {
  wp_cache_flush();
  \Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles();
  \Breakdance\Render\generateCacheForGlobalSettings();
  ob_start();
  foreach ($wpdb->get_col("SELECT DISTINCT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_breakdance_data'") as $id) { try { \Breakdance\Render\generateCacheForPost((int) $id); } catch (\Throwable $e) {} }
  ob_end_clean();
  if (class_exists('WpeCommon')) { \WpeCommon::purge_memcached(); \WpeCommon::purge_varnish_cache(); $log['wpe_purged'] = true; }
}
// Leftovers + SEO description lengths (non-blog).
$log['left_email'] = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", '%' . $wpdb->esc_like($EMAIL_OLD) . '%')) + (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_content LIKE %s", '%' . $wpdb->esc_like($EMAIL_OLD) . '%'));
$log['left_baton_rouge_area'] = $wpdb->get_col("SELECT CONCAT(p.ID,' ',p.post_type,' ',IFNULL(pm.meta_key,'content')) FROM {$wpdb->posts} p LEFT JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_value LIKE '%Baton Rouge area%' WHERE p.post_status='publish' AND p.post_type NOT IN ('post','revision','meta-box') AND (pm.meta_id IS NOT NULL OR p.post_content LIKE '%Baton Rouge area%')");
return $log;
