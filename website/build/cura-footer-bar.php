<?php
// Cura footer bar, matching the BlakSheep standard (e.g. tigertownconstruction.com):
//   © [year] Client  |  Privacy · Cookies · Terms · Accessibility · Sitemap  |  Powered by [all-white BlakSheep Creative logo]
// Also creates the /sitemap/ page (SEOPress HTML sitemap) the bar links to. Idempotent.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
$log = [];

// 1. BlakSheep credit logo (white SVG). WP blocks SVG uploads, so register the file as an attachment directly.
$src = '/Users/clintsanchez/Documents/Claude/cura-mobility-services/brand/assets/credits/blaksheep-creative-all-white.svg';
$ex = get_posts(['post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'meta_key' => '_cura_source', 'meta_value' => $src]);
if ($ex) { $svgId = $ex[0]->ID; } else {
  $up = wp_upload_dir(); $dest = trailingslashit($up['path']) . 'blaksheep-creative-all-white.svg';
  copy($src, $dest);
  $svgId = wp_insert_attachment(['post_mime_type' => 'image/svg+xml', 'post_title' => 'BlakSheep Creative (all white)', 'post_status' => 'inherit'], $dest);
  update_post_meta($svgId, '_cura_source', $src);
  wp_update_attachment_metadata($svgId, ['width' => 1080, 'height' => 383, 'file' => _wp_relative_upload_path($dest)]);
}
update_post_meta($svgId, '_wp_attachment_image_alt', 'Website & SEO by BlakSheep Creative');
$svgUrl = wp_get_attachment_url($svgId);
$log['credit_logo'] = [$svgId, $svgUrl];

// 2. Sitemap page: the Single Policy layout (banner + 66/33 with contact card and policy links),
//    SEOPress HTML sitemap in the main column.
$page = get_page_by_path('sitemap');
$pid = $page ? $page->ID : wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Sitemap', 'post_name' => 'sitemap', 'post_author' => 1]);
$tpl = get_posts(['post_type' => 'breakdance_template', 'title' => 'Single Policy', 'numberposts' => 1])[0]->ID;
[$tj, $t] = cura_bd_load($tpl);
$main = &cura_bd_node($t['root'], 112);
$sc = ['id' => 0, 'data' => ['type' => 'EssentialElements\\Shortcode', 'properties' => ['content' => ['shortcode' => ['full_shortcode' => '[seopress_html_sitemap]']], 'settings' => ['advanced' => ['classes' => ['cura-prose', 'cura-sitemap']]]]], 'children' => []];
cura_bd_reid($sc, $t);
$main['children'] = [$sc];
unset($main);
cura_bd_save($pid, ['tree_json_string' => ''], $t);
$log['sitemap_page'] = [$pid, get_permalink($pid)];

// 3. Footer bar (Footer 244, section 143 > Columns 172): copyright | policy links | credit.
[$fj, $f] = cura_bd_load(244);
cura_bd_set($f, 172, 'settings.advanced.classes', ['cura-footer-bar']);
$links = [['Privacy', '/policies/privacy-policy/'], ['Cookies', '/policies/cookie-policy/'], ['Terms', '/policies/terms-conditions/'], ['Accessibility', '/policies/accessibility-statement/'], ['Sitemap', '/sitemap/']];
$html = '<nav class="cura-footer-links" aria-label="Policies and sitemap">' . implode('', array_map(fn($l) => '<a href="' . esc_url(home_url($l[1])) . '">' . $l[0] . '</a>', $links)) . '</nav>';
$cols = &cura_bd_node($f['root'], 172);
$copyCol = null; foreach ($cols['children'] as $c) if ($c['id'] == 173) $copyCol = $c;
$linkCol = ['id' => 0, 'data' => ['type' => 'EssentialElements\\Column', 'properties' => ['settings' => ['advanced' => ['classes' => ['cura-footer-bar__links']]]]], 'children' => [
  cura_bd_el('Text', ['content' => ['content' => ['text' => $html]]]),
]];
$creditCol = ['id' => 0, 'data' => ['type' => 'EssentialElements\\Column', 'properties' => ['settings' => ['advanced' => ['classes' => ['cura-footer-bar__credit']]]]], 'children' => [
  cura_bd_el('Text', ['content' => ['content' => ['text' => 'Powered by']]]),
  cura_bd_el('Image', ['content' => ['content' => [
    'image' => ['id' => $svgId, 'filename' => 'blaksheep-creative-all-white.svg', 'url' => $svgUrl, 'alt' => 'Website & SEO by BlakSheep Creative', 'caption' => '', 'mime' => 'image/svg+xml', 'type' => 'image', 'sizes' => ['full' => ['url' => $svgUrl, 'width' => 1080, 'height' => 383, 'orientation' => 'landscape']], 'attributes' => ['srcset' => '', 'sizes' => '']],
    'link' => ['link_type' => 'url', 'url' => 'https://blaksheepcreative.com/services/web-design-development/baton-rouge/', 'new_tab' => true], // Image element link format
  ]]]),
]];
cura_bd_reid($linkCol, $f); cura_bd_reid($creditCol, $f);
$cols['children'] = [$copyCol, $linkCol, $creditCol];
unset($cols);
cura_bd_save(244, $fj, $f);

// 4. Styles.
$css = "/* Footer bar: © | policy + sitemap links | Powered by BlakSheep (BlakSheep standard) */\n.breakdance .cura-footer-bar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px 24px}\n.breakdance .cura-footer-bar > .bde-column{width:auto;flex:0 1 auto}\n.cura-footer-links{display:flex;flex-wrap:wrap;gap:4px 18px;justify-content:center}\n.breakdance .cura-footer-bar .bde-text,.breakdance .cura-footer-links a{color:#FFFFFF}\n.cura-footer-links a{text-decoration:none;font-size:14px}\n.cura-footer-links a:hover,.cura-footer-links a:focus-visible{text-decoration:underline}\n.breakdance .cura-footer-bar__credit{flex-direction:row;align-items:center;gap:10px}\n.breakdance .cura-footer-bar__credit .bde-text{font-size:14px;white-space:nowrap}\n.breakdance .cura-footer-bar__credit .bde-image{width:120px}\n.breakdance .cura-footer-bar__credit img{width:120px;height:auto;display:block}\n@media (max-width:767px){.breakdance .cura-footer-bar{flex-direction:column;justify-content:center;text-align:center}}\n/* Sitemap page list */\n.cura-sitemap ul{list-style:disc;padding-left:22px}\n.cura-sitemap h2,.cura-sitemap h3{font-size:20px;margin:24px 0 8px}";
$gs = json_decode(json_decode(get_option('breakdance_global_settings_json_string')), true); $ss = $gs['settings']['code']['stylesheets'];
$pos = array_search('Cura: footer bar', array_column($ss, 'name')); $e = ['name' => 'Cura: footer bar', 'code' => $css];
if ($pos === false) $ss[] = $e; else $ss[$pos] = $e;
$gs['settings']['code']['stylesheets'] = $ss; \Breakdance\Data\save_global_settings(json_encode(['settings' => $gs['settings']]));
\Breakdance\Render\clearAllCssCachesAndDeleteCachedFiles(); \Breakdance\Render\generateCacheForGlobalSettings();
foreach ([244, $pid, 67, 176, 180, 182, 186, 202, 204, 206, 208, 1383, 1384, 1385, 1386, 1387, 1454, 1456, 1485, 1487, 1488, 1489] as $id) \Breakdance\Render\generateCacheForPost($id);
return $log;
