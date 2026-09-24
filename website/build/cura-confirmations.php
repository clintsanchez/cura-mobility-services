<?php
// Cura confirmations: "Confirmation Content" field group (conf_h1 hero title + conf_content wysiwyg, same field
// names as the Tiger Town build) and content for each confirmation post. Idempotent.
$log = [];

// 1. Field group (Meta Box Builder format, mirrors Service Content 1337).
$base = ['required' => false, 'disabled' => false, 'readonly' => false, 'clone' => false, 'clone_empty_start' => false, 'hide_from_rest' => false, 'hide_from_front' => false, 'save_field' => true, 'desc' => ''];
$fields = [
  array_merge($base, ['name' => 'Hero title', 'id' => 'conf_h1', 'type' => 'text', 'required' => true, 'desc' => 'Large title in the page banner (the H1). The post title is still used in the breadcrumb and admin.']),
  array_merge($base, ['name' => 'Content', 'id' => 'conf_content', 'type' => 'wysiwyg', 'raw' => false, 'options' => ['textarea_rows' => 12, 'media_buttons' => false], 'desc' => 'Thank-you message and next steps, shown above the Back to home and Call buttons.']),
];
$mb = ['title' => 'Confirmation Content', 'id' => 'confirmation-content', 'post_types' => ['confirmation'], 'autosave' => false, 'default_hidden' => false, 'modified' => time(), 'fields' => $fields];
$builderFields = []; foreach ($fields as $f) { $f['_id'] = $f['id']; $builderFields[$f['id']] = $f; }
$settings = ['title' => 'Confirmation Content', 'id' => 'confirmation-content', 'object_type' => 'post', 'post_types' => ['confirmation'], 'priority' => 'high', 'style' => 'default', 'closed' => false, 'context' => 'normal', 'autosave' => false, 'default_hidden' => false, 'revision' => false, 'prefix' => '', 'text_domain' => 'your-text-domain', 'modified' => (string) time(), 'custom_table' => ['enable' => false]];
$ex = get_posts(['post_type' => 'meta-box', 'name' => 'confirmation-content', 'post_status' => 'any', 'numberposts' => 1]);
$gid = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'meta-box', 'post_status' => 'publish', 'post_title' => 'Confirmation Content', 'post_name' => 'confirmation-content']);
update_post_meta($gid, 'settings', $settings); update_post_meta($gid, 'fields', $builderFields); update_post_meta($gid, 'meta_box', $mb);
$log['field_group'] = $gid;

// 2. Content per confirmation (call-only, no promises beyond what the site already makes).
$steps = function ($lead, array $items) {
  return '<p>' . $lead . '</p>' . "\n\n" . '<h2>What happens next</h2>' . "\n" . '<ol><li>' . implode('</li><li>', $items) . '</li></ol>' . "\n\n"
    . '<p>Need us sooner? Call <a href="tel:+12253630845">(225) 363-0845</a>. For a medical emergency, call 911.</p>';
};
$content = [
  'quote' => ['Thanks. We got your quote request.', $steps('We will call you soon with a clear price for your ride.', ['We review your ride details.', 'We call you to confirm the pickup, the ride type and any mobility needs.', 'You get a clear price before anything is booked.'])],
  'estimate' => ['Thanks. We got your estimate request.', $steps('We will call you soon with an estimate for your ride.', ['We review your trip details.', 'We call you to go over the ride type and any mobility needs.', 'You get a clear price before anything is booked.'])],
  'consultation' => ['Thanks. We will call you to talk it through.', $steps('We will call you soon to learn about the rider and help you choose the right ride.', ['We review what you shared.', 'We call you to talk about the rider, the trips and any mobility needs.', 'We help you set up a ride or a recurring schedule if you are ready.'])],
  'appointment' => ['Thanks. We got your request.', $steps('We will call you soon to confirm a time to talk.', ['We review your request.', 'We call you to confirm the details.', 'You get a clear price before any ride is booked.'])],
];
foreach ($content as $slug => [$h1, $body]) {
  $p = get_posts(['post_type' => 'confirmation', 'name' => $slug, 'post_status' => 'any', 'numberposts' => 1]);
  if (!$p) continue;
  update_post_meta($p[0]->ID, 'conf_h1', $h1);
  update_post_meta($p[0]->ID, 'conf_content', $body);
  $log['posts'][$slug] = $p[0]->ID;
}
return $log;
