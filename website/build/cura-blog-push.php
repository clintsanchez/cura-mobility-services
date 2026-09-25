<?php
// Cura blog: push rendered posts (blog/posts/<slug>.render.json from scripts/render_post.py) as DRAFTS.
// Idempotent by slug: updates the existing post if found. Author 2 (Cura Mobility Services), category 40
// (Caregiver guides). Featured image sideloaded from blog/posts/featured-images/<slug>.webp once.
// FAQ JSON-LD (the .faq-schema.html sidecar) is appended as a Gutenberg HTML block. Never publishes.
$BLOG = '/Users/clintsanchez/Documents/Claude/cura-mobility-services/blog/posts';
$SLUGS = ['medical-rides-for-aging-parents-baton-rouge', 'planning-ride-home-hospital-discharge', 'wheelchair-walker-parent-appointments'];
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
wp_set_current_user(1);
kses_remove_filters(); // inline SVG figures + JSON-LD script
$log = [];
foreach ($SLUGS as $slug) {
  $d = json_decode(file_get_contents("$BLOG/$slug.render.json"), true);
  $content = $d['content'];
  $faq = @file_get_contents("$BLOG/$slug.faq-schema.html");
  if ($faq) $content .= "\n\n<!-- wp:html -->\n" . trim($faq) . "\n<!-- /wp:html -->";

  $ex = get_posts(['post_type' => 'post', 'name' => $slug, 'post_status' => 'any', 'numberposts' => 1]);
  if ($ex && $ex[0]->post_status === 'publish') { $log[$slug] = 'SKIPPED: already published'; continue; }
  $arr = ['post_type' => 'post', 'post_status' => 'draft', 'post_title' => $d['title'], 'post_name' => $slug,
          'post_content' => $content, 'post_excerpt' => $d['excerpt'], 'post_author' => 2, 'post_category' => [40]];
  if ($ex) $arr['ID'] = $ex[0]->ID;
  $id = wp_insert_post(wp_slash($arr), true);
  if (is_wp_error($id)) { $log[$slug] = $id->get_error_message(); continue; }

  // Featured image (once).
  $thumb = get_post_thumbnail_id($id);
  if (!$thumb) {
    $tmp = wp_tempnam("$slug.webp"); copy("$BLOG/featured-images/$slug.webp", $tmp);
    $thumb = media_handle_sideload(['name' => "$slug.webp", 'tmp_name' => $tmp], $id, $d['title']);
    if (!is_wp_error($thumb)) { set_post_thumbnail($id, $thumb); update_post_meta($thumb, '_wp_attachment_image_alt', $d['title']); }
  }
  $img = is_wp_error($thumb) ? '' : wp_get_attachment_url($thumb);

  $meta = ['_seopress_titles_title' => $d['seo_title'], '_seopress_titles_desc' => $d['seo_description'],
    '_seopress_analysis_target_kw' => $d['target_keyword'],
    '_seopress_social_fb_title' => $d['social_fb_title'], '_seopress_social_fb_desc' => $d['social_fb_desc'],
    '_seopress_social_twitter_title' => $d['social_twitter_title'], '_seopress_social_twitter_desc' => $d['social_twitter_desc']];
  if ($img) $meta += ['_seopress_social_fb_img' => $img, '_seopress_social_fb_img_attachment_id' => $thumb,
    '_seopress_social_fb_img_width' => 1080, '_seopress_social_fb_img_height' => 608,
    '_seopress_social_twitter_img' => $img, '_seopress_social_twitter_img_attachment_id' => $thumb,
    '_seopress_social_twitter_img_width' => 1080, '_seopress_social_twitter_img_height' => 608];
  foreach ($meta as $k => $v) update_post_meta($id, $k, $v);

  $p = get_post($id);
  $log[$slug] = ['id' => $id, 'status' => $p->post_status, 'author' => $p->post_author, 'cats' => wp_get_post_categories($id),
    'thumb' => $thumb, 'svg_kept' => substr_count($p->post_content, '<svg'), 'ld_json' => substr_count($p->post_content, 'application/ld+json'),
    'preview' => get_preview_post_link($id)];
}
kses_init_filters();
return $log;
