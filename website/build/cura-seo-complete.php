<?php
// Cura SEO completion pass (2026-09-24), after a full audit of every public post type and taxonomy:
// 1. SEOPress focus keywords (_seopress_analysis_target_kw) for every indexed page, service, form and policy,
//    from seo/keyword-research.md §3 (primary first, then secondaries). Blog posts already had theirs.
// 2. Blog post tags from each post's frontmatter (post_tag archives stay noindex in SEOPress).
// 3. Resources page (posts page) OG/Twitter image.
// 4. "Caregiver guides" category: SEOPress title, description, OG/Twitter title/description/image.
// 5. Pack demo terms removed: empty categories (Taxi news, Elder care, ...) and empty demo tags (tag-1..4, ...).
//    Default category moved to Caregiver guides first so Uncategorized can go.
// Idempotent.
$log = [];

// 1. Focus keywords.
$kw = [
  'page' => [
    'home' => 'non emergency medical transportation baton rouge, medical transportation baton rouge, non emergency medical transportation near me',
    'about-us' => 'cura mobility services, medical transportation company baton rouge',
    'services' => 'medical transportation services baton rouge, medical transportation companies in baton rouge',
    'rates' => 'medical transportation rates baton rouge, how much does non emergency medical transportation cost',
    'faqs' => 'non emergency medical transportation faqs, what is non emergency medical transportation',
    'reviews' => 'cura mobility services reviews',
    'contact-us' => 'contact cura mobility services',
    'book-a-ride' => 'book medical transportation baton rouge, schedule a medical ride',
    'sitemap' => 'cura mobility services sitemap',
    'resources' => 'caregiver resources baton rouge, medical ride guides for caregivers',
  ],
  'services' => [
    'doctor-appointment-rides' => 'doctor appointment transportation baton rouge, ambulatory transportation baton rouge',
    'dialysis-transportation' => 'dialysis transportation baton rouge, dialysis transportation near me',
    'wheelchair-transportation' => 'wheelchair transportation baton rouge, wheelchair transportation near me',
    'hospital-discharge-rides' => 'hospital discharge transportation baton rouge',
    'treatment-and-therapy-rides' => 'treatment and therapy transportation baton rouge, rides to chemo baton rouge',
    'senior-and-everyday-rides' => 'senior transportation baton rouge, senior transportation near me',
    'prescription-pickup-and-delivery' => 'prescription delivery baton rouge, prescription pickup service',
    'long-distance-medical-transportation' => 'long distance medical transportation, long distance medical transportation baton rouge',
    'recurring-rides' => 'recurring medical transportation baton rouge, standing rides to dialysis and therapy',
  ],
  'forms' => [
    'quote' => 'medical transportation quote baton rouge',
    'estimate' => 'medical transportation estimate baton rouge',
    'consultation' => 'medical transportation consultation baton rouge',
    'appointment' => 'schedule medical transportation baton rouge',
  ],
  'policies' => [
    'privacy-policy' => 'cura mobility services privacy policy',
    'terms-conditions' => 'cura mobility services terms and conditions',
    'cookie-policy' => 'cura mobility services cookie policy',
    'website-disclaimer' => 'cura mobility services website disclaimer',
    'accessibility-statement' => 'cura mobility services accessibility statement',
  ],
];
foreach ($kw as $pt => $map) foreach ($map as $slug => $k) {
  $p = get_page_by_path($slug, OBJECT, $pt);
  if (!$p && $slug === 'home') $p = get_post((int) get_option('page_on_front'));
  if (!$p) { $log['kw_missing'][] = "$pt/$slug"; continue; }
  update_post_meta($p->ID, '_seopress_analysis_target_kw', $k);
  $log['kw'][] = $p->ID;
}

// 2. Blog post tags (from frontmatter).
$tags = [
  'medical-rides-for-aging-parents-baton-rouge' => ['Caregivers', 'Aging parents', 'Medical transportation', 'Baton Rouge'],
  'planning-ride-home-hospital-discharge' => ['Caregivers', 'Aging parents', 'Hospital discharge', 'Baton Rouge'],
  'wheelchair-walker-parent-appointments' => ['Caregivers', 'Aging parents', 'Wheelchairs and walkers', 'Fall prevention', 'Baton Rouge'],
];
foreach ($tags as $slug => $t) {
  $p = get_page_by_path($slug, OBJECT, 'post');
  if ($p) { wp_set_post_tags($p->ID, $t, false); $log['tags'][$p->ID] = wp_list_pluck(wp_get_post_tags($p->ID), 'name'); }
}

// 3. Resources page social image (same 1200x630 crop family as the other pages).
$res = get_page_by_path('resources');
$og = 1526; // daughter-and-senior-mother-looking-at-phone-og.jpg, 1200x630
if ($res) {
  $url = wp_get_attachment_url($og);
  foreach (['fb', 'twitter'] as $n) {
    update_post_meta($res->ID, "_seopress_social_{$n}_img", $url);
    update_post_meta($res->ID, "_seopress_social_{$n}_img_attachment_id", $og);
    update_post_meta($res->ID, "_seopress_social_{$n}_img_width", 1200);
    update_post_meta($res->ID, "_seopress_social_{$n}_img_height", 630);
  }
  $log['resources_og'] = $url;
}

// 4. Caregiver guides category.
$cat = get_term_by('slug', 'caregiver-guides', 'category');
if ($cat) {
  $img = 1530; // caregiver-helping-senior-woman-into-car-with-walker-og.jpg
  $m = [
    '_seopress_titles_title' => 'Caregiver guides for medical rides | Cura Mobility Services',
    '_seopress_titles_desc' => 'Practical guides for Baton Rouge families: arranging medical rides for a parent, planning the ride home from the hospital and helping a loved one with a walker or wheelchair.',
    '_seopress_social_fb_title' => 'Caregiver guides',
    '_seopress_social_fb_desc' => 'Practical guides for families arranging medical rides and appointments for someone they care for.',
    '_seopress_social_twitter_title' => 'Caregiver guides',
    '_seopress_social_twitter_desc' => 'Practical guides for families arranging medical rides and appointments for someone they care for.',
  ];
  foreach ($m as $k => $v) update_term_meta($cat->term_id, $k, $v);
  foreach (['fb', 'twitter'] as $n) {
    update_term_meta($cat->term_id, "_seopress_social_{$n}_img", wp_get_attachment_url($img));
    update_term_meta($cat->term_id, "_seopress_social_{$n}_img_attachment_id", $img);
    update_term_meta($cat->term_id, "_seopress_social_{$n}_img_width", 1200);
    update_term_meta($cat->term_id, "_seopress_social_{$n}_img_height", 630);
  }
  $log['category'] = $cat->term_id;

  // 5. Pack demo terms (only if empty).
  update_option('default_category', $cat->term_id);
  foreach (['elder-care', 'health-wellness', 'nutrition', 'rehabilitation', 'senior-living', 'taxi-news', 'uncategorized'] as $s) {
    $t = get_term_by('slug', $s, 'category');
    if ($t && (int) $t->count === 0) { wp_delete_term($t->term_id, 'category'); $log['deleted_categories'][] = $s; }
  }
  foreach (['dementia', 'diet', 'family-guide', 'healing', 'healthy-eating', 'mental-health', 'mobility', 'nursing-home', 'senior-safety', 'seniors', 'tag-1', 'tag-2', 'tag-3', 'tag-4'] as $s) {
    $t = get_term_by('slug', $s, 'post_tag');
    if ($t && (int) $t->count === 0) { wp_delete_term($t->term_id, 'post_tag'); $log['deleted_tags'][] = $s; }
  }
}
return $log;
