<?php
// Cura blog: refresh the CONTENT of already-published posts from blog/posts/<slug>.render.json (+ FAQ schema
// sidecar), same assembly as cura-blog-push.php. Leaves status, date, author, meta and featured image alone.
$BLOG = '/Users/clintsanchez/Documents/Claude/cura-mobility-services/blog/posts';
$SLUGS = ['medical-rides-for-aging-parents-baton-rouge', 'planning-ride-home-hospital-discharge', 'wheelchair-walker-parent-appointments'];
wp_set_current_user(1);
kses_remove_filters();
$log = [];
foreach ($SLUGS as $slug) {
  $p = get_posts(['post_type' => 'post', 'name' => $slug, 'post_status' => 'any', 'numberposts' => 1]);
  if (!$p) { $log[$slug] = 'not found'; continue; }
  $d = json_decode(file_get_contents("$BLOG/$slug.render.json"), true);
  $content = $d['content'];
  $faq = @file_get_contents("$BLOG/$slug.faq-schema.html");
  if ($faq) $content .= "\n\n<!-- wp:html -->\n" . trim($faq) . "\n<!-- /wp:html -->";
  wp_update_post(wp_slash(['ID' => $p[0]->ID, 'post_content' => $content]));
  $q = get_post($p[0]->ID);
  preg_match_all('#href="(/caregiver-guides/[^"]+)"#', $q->post_content, $m);
  $log[$slug] = ['id' => $q->ID, 'status' => $q->post_status, 'date' => $q->post_date, 'svg' => substr_count($q->post_content, '<svg'),
    'ld' => substr_count($q->post_content, 'ld+json'), 'post_links' => array_count_values($m[1])];
}
kses_init_filters();
return $log;
