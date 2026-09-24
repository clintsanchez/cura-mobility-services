<?php
// Cura: apply SEO metadata (cura-seo-meta.php) + noindex non-content CPTs/taxonomies. Idempotent.
require_once WP_CONTENT_DIR . '/novamira-sandbox/cura-bd.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
$W = '/Users/clintsanchez/pCloud Drive/Documents/BlakSheep Creative/Clients/Cura Mobility Services/05-Photos/web/';
$meta = require __DIR__ . '/cura-seo-meta.php';
$log = ['too_long' => [], 'applied' => [], 'og' => []];

// 1200x630 OG crop from a source image (cached by source path).
$ogImage = function ($srcPath, $label) use (&$log) {
  $key = 'og1200x630:' . $srcPath;
  $ex = get_posts(['post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => 1, 'meta_key' => '_cura_source', 'meta_value' => $key]);
  if ($ex) return (int) $ex[0]->ID;
  $ed = wp_get_image_editor($srcPath); if (is_wp_error($ed)) { $log['og_errors'][] = $srcPath . ': ' . $ed->get_error_message(); return 0; }
  $s = $ed->get_size(); $tw = 1200; $th = 630;
  $scale = max($tw / $s['width'], $th / $s['height']); $cw = (int) round($tw / $scale); $ch = (int) round($th / $scale);
  $ed->crop((int) (($s['width'] - $cw) / 2), (int) (($s['height'] - $ch) / 2), $cw, $ch, $tw, $th);
  $ed->set_quality(82);
  $up = wp_upload_dir(); $name = sanitize_file_name(pathinfo($srcPath, PATHINFO_FILENAME)) . '-og.jpg';
  $saved = $ed->save(trailingslashit($up['path']) . $name, 'image/jpeg'); if (is_wp_error($saved)) { $log['og_errors'][] = $saved->get_error_message(); return 0; }
  $id = wp_insert_attachment(['post_mime_type' => 'image/jpeg', 'post_title' => 'OG: ' . $label, 'post_status' => 'inherit'], $saved['path']);
  wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $saved['path']));
  update_post_meta($id, '_cura_source', $key);
  update_post_meta($id, '_wp_attachment_image_alt', $label);
  return (int) $id;
};

foreach ($meta as $pt => $items) {
  foreach ($items as $slug => $row) {
    [$title, $desc, $ogTitle, $ogDesc, $imgSrc] = $row; $excerpt = $row[5] ?? null;
    $post = $pt === 'page' && $slug === 'home' ? get_post((int) get_option('page_on_front')) : (get_posts(['post_type' => $pt, 'name' => $slug, 'post_status' => 'publish', 'numberposts' => 1])[0] ?? null);
    if (!$post) { $log['missing'][] = "$pt/$slug"; continue; }
    foreach (['title' => [$title, 60], 'desc' => [$desc, 160], 'og_desc' => [$ogDesc, 200]] as $k => [$v, $max]) if (mb_strlen($v) > $max) $log['too_long'][] = "$pt/$slug $k " . mb_strlen($v);
    // OG image source
    if ($imgSrc === 'featured') { $src = get_attached_file(get_post_thumbnail_id($post->ID)); $label = $post->post_title; }
    else { $src = $W . $imgSrc; $label = $post->post_title; }
    $og = $src && file_exists($src) ? $ogImage($src, $label . ' | Cura Mobility Services') : 0;
    $ogUrl = $og ? wp_get_attachment_url($og) : '';
    update_post_meta($post->ID, '_seopress_titles_title', $title);
    update_post_meta($post->ID, '_seopress_titles_desc', $desc);
    update_post_meta($post->ID, '_seopress_social_fb_title', $ogTitle);
    update_post_meta($post->ID, '_seopress_social_fb_desc', $ogDesc);
    update_post_meta($post->ID, '_seopress_social_twitter_title', $ogTitle);
    update_post_meta($post->ID, '_seopress_social_twitter_desc', $ogDesc);
    if ($og) foreach (['fb', 'twitter'] as $n) {
      update_post_meta($post->ID, "_seopress_social_{$n}_img", $ogUrl);
      update_post_meta($post->ID, "_seopress_social_{$n}_img_attachment_id", $og);
      update_post_meta($post->ID, "_seopress_social_{$n}_img_width", 1200);
      update_post_meta($post->ID, "_seopress_social_{$n}_img_height", 630);
    }
    if ($excerpt !== null) wp_update_post(['ID' => $post->ID, 'post_excerpt' => $excerpt]);
    $log['applied'][] = "$pt/$slug";
    $log['og'][$pt . '/' . $slug] = $og;
  }
}

// Noindex (and drop from the XML sitemap): confirmations + loop-only / unused CPTs and their taxonomies.
$t = get_option('seopress_titles_option_name', []);
foreach (['confirmation', 'faqs', 'review', 'team', 'locations', 'products'] as $cpt) { $t['seopress_titles_single_titles'][$cpt]['noindex'] = '1'; $t['seopress_titles_single_titles'][$cpt]['nofollow'] = $cpt === 'confirmation' ? '1' : ($t['seopress_titles_single_titles'][$cpt]['nofollow'] ?? ''); }
foreach (['faq-categories', 'review-categories', 'service-categories'] as $tax) $t['seopress_titles_tax_titles'][$tax]['noindex'] = '1';
update_option('seopress_titles_option_name', $t);
$sm = get_option('seopress_xml_sitemap_option_name', []);
foreach (['confirmation', 'faqs', 'review', 'team', 'locations', 'products'] as $cpt) unset($sm['seopress_xml_sitemap_post_types_list'][$cpt]);
foreach (['post', 'page', 'services', 'policies', 'forms'] as $cpt) $sm['seopress_xml_sitemap_post_types_list'][$cpt]['include'] = '1';
foreach (['faq-categories', 'review-categories', 'service-categories'] as $tax) unset($sm['seopress_xml_sitemap_taxonomies_list'][$tax]);
update_option('seopress_xml_sitemap_option_name', $sm);
$log['sitemap_post_types'] = array_keys($sm['seopress_xml_sitemap_post_types_list']);
return $log;
