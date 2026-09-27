<?php
// Cura: two services Michael confirmed on 2026-09-25 ("airport transfers, private rides, for individuals or groups")
// plus a general FAQ making the no-stretcher scope explicit (his 2026-09-27 reply). Same structure as the other 9
// services: Meta Box fields, highlights, 5 FAQs via faq_to_service, SEOPress fields, card icon.
// Guardrails: statewide, one wheelchair-accessible van (book early), no group-size or flight-tracking promises,
// no licensing/insurance claims, no phone numbers in text (buttons carry the dynamic number). Idempotent by slug.
// Needs: $ICONS = ['plane' => '<svg…>', 'user-group' => '<svg…>'] (Font Awesome 6 solid), defined by the caller.
global $wpdb;
$log = [];

// Icons for the service cards.
$icons = get_option('cura_icons', []);
foreach ($ICONS as $k => $svg) $icons[$k] = ['name' => $k, 'svg' => $svg];
update_option('cura_icons', $icons);

$rates = '<p>You get a clear price before any ride is booked. <a href="/rates/">See how our pricing works</a>.</p>';
$list = fn(array $i) => '<ul><li>' . implode('</li><li>', $i) . '</li></ul>';
$services = [
  'airport-transfers' => [
    'title' => 'Airport transfers', 'order' => 10, 'icon' => 'plane',
    'excerpt' => 'Rides to and from the airport, with help with your bags and a pickup planned around your flight.',
    'img' => ['thumb' => 1455, 'banner' => 1292, 'detail' => 1484],
    'hero_subhead' => 'Rides to and from the airport, with help from your door to the terminal and a clear price before you book.',
    'intro' => '<p>Travel days are stressful enough. We pick you up at home, help with your bags and get you to the airport with time to spare, then bring you home when you land.</p>' . "\n\n" . '<p>We give airport rides across Louisiana, including the Baton Rouge and New Orleans airports. Tell us your flight times when you book, and we plan the pickup around them.</p>',
    'highlights' => ['Pickup planned around your flight', 'Help with bags and mobility aids', 'Door-to-door, from home to the terminal', 'A wheelchair-accessible van', 'A clear price before you book'],
    'who_heading' => 'Who our airport rides are for',
    'who_for' => '<p>This ride is a good fit if you:</p>' . $list(['Are flying out or coming home and would rather not drive or park', 'Need help with bags, a walker or a wheelchair on travel day', 'Are arranging a ride for a parent or relative who is traveling']),
    'how_heading' => 'How to book an airport ride',
    'area_heading' => 'Airport rides from Baton Rouge across Louisiana',
    'area_text' => '<p>We give rides to and from airports across Louisiana, including Baton Rouge and New Orleans. Tell us your airport and flight times when you book. Call us to plan your ride.</p>' . $rates,
    'faq_heading' => 'Airport ride questions',
    'faqs' => [
      ['Which airports do you drive to?', 'We drive to and from airports across Louisiana, including Baton Rouge and New Orleans. Tell us your airport and flight times when you book.'],
      ['How early will you pick me up for my flight?', 'We plan the pickup with you based on your flight time and the drive, so you arrive with time to check in. Call us to set it up.'],
      ['Can you pick me up when I land?', 'Yes. Tell us your arrival time when you book, and call us if your flight changes.'],
      ['Can you help with my luggage?', 'Yes. Your driver helps load and unload your bags. Let us know how many bags you are bringing.'],
      ['Can you take a wheelchair user to the airport?', 'Yes. We have a wheelchair-accessible van. It is one van, so please book as early as you can.'],
    ],
    'seo_title' => 'Airport transfers from Baton Rouge | Cura Mobility Services',
    'seo_desc' => 'Door-to-door rides to and from the airport, from Baton Rouge and across Louisiana. Help with bags and mobility aids, and a clear price before you book.',
    'og_title' => 'Airport rides, door to terminal',
    'og_desc' => 'Rides to and from the airport with help with your bags and a pickup planned around your flight.',
    'kw' => 'airport transportation baton rouge, airport transfers baton rouge',
  ],
  'private-and-group-rides' => [
    'title' => 'Private and group rides', 'order' => 11, 'icon' => 'user-group',
    'excerpt' => 'Private rides for one rider or a small group, to events, family visits and anywhere you need to go.',
    'img' => ['thumb' => 1291, 'banner' => 1296, 'detail' => 1291],
    'hero_subhead' => 'Private rides for one rider or a small group, planned around your day, with door-to-door help.',
    'intro' => '<p>Not every ride is to an appointment. Book a private ride for yourself, or bring family and friends along to a wedding, a church service, a reunion or a day out.</p>' . "\n\n" . '<p>Tell us how many people are riding and about any mobility needs, and we will plan the right ride for your group.</p>',
    'highlights' => ['Private rides, just for you', 'Room for family and friends', 'Door-to-door help for every rider', 'Help for walkers and wheelchairs', 'A clear price before you book'],
    'who_heading' => 'Who our private and group rides are for',
    'who_for' => '<p>This ride is a good fit if you:</p>' . $list(['Want a private ride instead of a rideshare or the bus', 'Are going somewhere with family or friends', 'Have riders in your group who use a walker or wheelchair']),
    'how_heading' => 'How to book a private or group ride',
    'area_heading' => 'Private and group rides across Louisiana',
    'area_text' => '<p>We give private and group rides from the Baton Rouge area to anywhere in Louisiana. Tell us where you are going, when, and how many people are riding. Call us to plan your ride.</p>' . $rates,
    'faq_heading' => 'Private and group ride questions',
    'faqs' => [
      ['How many people can ride together?', 'Tell us how many people are riding when you book, and we will let you know what fits. For larger groups, call us to plan the trip.'],
      ['Do I need a medical reason to book a private ride?', 'No. Private rides are for anywhere you need to go, from errands to family events.'],
      ['Can you make more than one stop on a private ride?', 'Yes. Tell us each stop when you book, and we will plan the route and the price with you.'],
      ['Can someone in our group use a wheelchair?', 'Yes. We have a wheelchair-accessible van. Tell us about each rider\'s mobility needs when you book.'],
      ['Can you wait and bring our group home?', 'Yes. Book a round trip and we will plan the return pickup with you.'],
    ],
    'seo_title' => 'Private and group rides in Baton Rouge | Cura',
    'seo_desc' => 'Private rides for one rider or a small group, from Baton Rouge to anywhere in Louisiana. Door-to-door help for every rider and a clear price before you book.',
    'og_title' => 'Private and group rides',
    'og_desc' => 'A private ride for you, or room for family and friends, with door-to-door help for every rider.',
    'kw' => 'private transportation baton rouge, group transportation baton rouge',
  ],
];

$faqPost = function ($q, $a, $order, $term) {
  $ex = get_posts(['post_type' => 'faqs', 'title' => $q, 'post_status' => 'any', 'numberposts' => 1]);
  $id = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'faqs', 'post_status' => 'publish', 'post_title' => $q, 'menu_order' => $order, 'post_author' => 1]);
  update_post_meta($id, 'question', $q);
  update_post_meta($id, 'answer', '<p>' . $a . '</p>');
  wp_set_object_terms($id, $term, 'faq-categories');
  return $id;
};

foreach ($services as $slug => $s) {
  $ex = get_page_by_path($slug, OBJECT, 'services');
  $args = ['post_type' => 'services', 'post_status' => 'publish', 'post_title' => $s['title'], 'post_name' => $slug, 'menu_order' => $s['order'], 'post_excerpt' => $s['excerpt'], 'post_author' => 1];
  if ($ex) $args['ID'] = $ex->ID;
  $id = wp_insert_post(wp_slash($args));
  set_post_thumbnail($id, $s['img']['thumb']);
  update_post_meta($id, 'banner_image', $s['img']['banner']);
  update_post_meta($id, 'detail_image', $s['img']['detail']);
  update_post_meta($id, 'card_icon', $s['icon']);
  update_post_meta($id, 'highlights', array_map(fn($t) => ['text' => $t], $s['highlights']));
  foreach (['hero_subhead', 'intro', 'who_heading', 'who_for', 'how_heading', 'area_heading', 'area_text', 'faq_heading'] as $k) update_post_meta($id, $k, $s[$k]);
  $img = wp_get_attachment_image_src($s['img']['thumb'], 'full');
  $seo = ['_seopress_titles_title' => $s['seo_title'], '_seopress_titles_desc' => $s['seo_desc'], '_seopress_analysis_target_kw' => $s['kw'],
    '_seopress_social_fb_title' => $s['og_title'], '_seopress_social_fb_desc' => $s['og_desc'],
    '_seopress_social_twitter_title' => $s['og_title'], '_seopress_social_twitter_desc' => $s['og_desc']];
  foreach (['fb', 'twitter'] as $n) $seo += ["_seopress_social_{$n}_img" => $img[0], "_seopress_social_{$n}_img_attachment_id" => $s['img']['thumb'], "_seopress_social_{$n}_img_width" => $img[1], "_seopress_social_{$n}_img_height" => $img[2]];
  foreach ($seo as $k => $v) update_post_meta($id, $k, $v);
  $faqIds = [];
  foreach ($s['faqs'] as $i => [$q, $a]) {
    $fid = $faqPost($q, $a, $i + 1, 'service-questions');
    $faqIds[] = $fid;
    MB_Relationships_API::add($fid, $id, 'faq_to_service');
  }
  $log[$slug] = ['id' => $id, 'url' => get_permalink($id), 'faqs' => $faqIds, 'seo_desc_len' => strlen($s['seo_desc'])];
}

// General FAQ: scope (no stretcher/ambulance).
$maxOrder = (int) $wpdb->get_var("SELECT MAX(p.menu_order) FROM {$wpdb->posts} p JOIN {$wpdb->term_relationships} tr ON tr.object_id = p.ID JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id JOIN {$wpdb->terms} t ON t.term_id = tt.term_id WHERE p.post_type = 'faqs' AND t.slug = 'general'");
$log['stretcher_faq'] = $faqPost('Do you offer stretcher or ambulance transport?', 'No. We give rides to passengers who walk on their own and passengers who use a wheelchair. We do not offer stretcher or ambulance transport. For a medical emergency, call 911.', $maxOrder + 1, 'general');

if (class_exists('WpeCommon')) { \WpeCommon::purge_memcached(); \WpeCommon::purge_varnish_cache(); }
return $log;
