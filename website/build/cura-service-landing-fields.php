<?php
// Cura service landing pages, step 1 (2026-09-24): three new fields in "Service Content" (field group 1337) and
// their content for all 9 services. Copy stays inside what the site already says (no vehicle, hours, coverage or
// licensing claims). Step 2 (cura-service-landing-template.php) wires them into Single Service (1387). Idempotent.
$log = [];
$base = ['required' => false, 'disabled' => false, 'readonly' => false, 'clone' => false, 'clone_empty_start' => false,
  'hide_from_rest' => false, 'hide_from_front' => false, 'save_field' => true];
$new = [
  'hero_subhead' => array_merge($base, ['name' => 'Hero subheading', 'id' => 'hero_subhead', 'type' => 'text',
    'desc' => 'One sentence under the page title in the banner. Say what the ride is and who it helps.']),
  'who_for' => array_merge($base, ['name' => 'Who it is for', 'id' => 'who_for', 'type' => 'wysiwyg', 'raw' => false,
    'options' => ['textarea_rows' => 6, 'media_buttons' => false],
    'desc' => 'Shown under the "Who this ride is for" heading. A short lead line and a 3-item list works best.']),
  'faq_heading' => array_merge($base, ['name' => 'FAQ heading', 'id' => 'faq_heading', 'type' => 'text',
    'desc' => 'Heading above the questions, e.g. "Hospital discharge ride questions". Falls back to "Common questions".']),
];
$mb = get_post_meta(1337, 'meta_box', true);
$bf = get_post_meta(1337, 'fields', true);
$ids = array_column($mb['fields'], 'id');
// Order: hero_subhead first, who_for after intro, faq_heading last.
$ordered = [];
foreach ($mb['fields'] as $f) {
  if ($f['id'] === 'intro' && !in_array('hero_subhead', $ids)) $ordered[] = $new['hero_subhead'];
  if (in_array($f['id'], ['hero_subhead', 'who_for', 'faq_heading'])) $f = $new[$f['id']]; // refresh on re-run
  $ordered[] = $f;
  if ($f['id'] === 'intro' && !in_array('who_for', $ids)) $ordered[] = $new['who_for'];
}
if (!in_array('faq_heading', $ids)) $ordered[] = $new['faq_heading'];
$mb['fields'] = $ordered;
$mb['modified'] = time();
$newBf = [];
foreach ($ordered as $f) { $b = $bf[$f['id']] ?? $f; if (isset($new[$f['id']])) $b = $new[$f['id']]; $b['_id'] = $f['id']; $newBf[$f['id']] = $b; }
update_post_meta(1337, 'meta_box', $mb);
update_post_meta(1337, 'fields', $newBf);
$log['fields'] = array_column($ordered, 'id');

$list = fn(array $items) => '<ul><li>' . implode('</li><li>', $items) . '</li></ul>';
$c = [
  'doctor-appointment-rides' => [
    'Door-to-door rides to checkups, specialists, labs and imaging across the Baton Rouge area, with a clear price before you book.',
    '<p>This ride is a good fit if you:</p>' . $list(['No longer drive, or should not drive to this appointment', 'Want a steady hand from your front door to the check-in desk', 'Have a family member who wants to book and plan the ride for you']),
    'Doctor visit ride questions'],
  'dialysis-transportation' => [
    'Standing rides to your dialysis center on the days you need them, with help to and from the chair.',
    '<p>This ride is a good fit if you:</p>' . $list(['Go to a dialysis center on a set schedule and do not drive', 'Feel tired after treatment and want help getting home', 'Have a family member or care facility setting up rides for you']),
    'Dialysis ride questions'],
  'wheelchair-transportation' => [
    'Patient, hands-on rides for people who use a wheelchair, walker or scooter, planned around your mobility needs.',
    '<p>This ride is a good fit if you:</p>' . $list(['Use a wheelchair, walker or scooter to get around', 'Need hands-on help from your door to your seat', 'Live at home or in a care facility and need rides to care or errands']),
    'Wheelchair ride questions'],
  'hospital-discharge-rides' => [
    'A calm ride home after a hospital stay, surgery or outpatient procedure, with help from the room to your door.',
    '<p>This ride is a good fit if you:</p>' . $list(['Are going home after a hospital stay, surgery or outpatient procedure', 'Should not drive yourself home after anesthesia or sedation', 'Are planning a parent\'s discharge and cannot be there to drive']),
    'Hospital discharge ride questions'],
  'treatment-and-therapy-rides' => [
    'Rides to chemo, infusions, physical therapy and wound care, one time or on a standing schedule.',
    '<p>This ride is a good fit if you:</p>' . $list(['Have ongoing treatment like chemo, infusions or physical therapy', 'Feel worn out after sessions and do not want to drive', 'Want the same pickup days and times each week']),
    'Treatment and therapy ride questions'],
  'senior-and-everyday-rides' => [
    'Safe, door-to-door rides for errands, the pharmacy, the grocery store and visits with family.',
    '<p>This ride is a good fit if you:</p>' . $list(['No longer drive but still want to get out and about', 'Need help with bags, a walker or getting in and out of the car', 'Are a family member looking for reliable rides for a parent']),
    'Senior and everyday ride questions'],
  'prescription-pickup-and-delivery' => [
    'A ride to the pharmacy, or pickup and delivery of your prescriptions to your door.',
    '<p>This service is a good fit if you:</p>' . $list(['Find it hard to get to the pharmacy', 'Are recovering at home and should stay off your feet', 'Are a caregiver who cannot make the pharmacy run']),
    'Prescription pickup questions'],
  'long-distance-medical-transportation' => [
    'Rides from the Baton Rouge area to specialists and hospitals farther away, planned around your appointment.',
    '<p>This ride is a good fit if you:</p>' . $list(['Have been referred to a specialist or hospital outside the area', 'Need comfort stops or extra help on a longer trip', 'Have family who cannot take a full day off to drive you']),
    'Long-distance ride questions'],
  'recurring-rides' => [
    'Set your rides up once for dialysis, therapy or treatment, and we handle every ride after that.',
    '<p>This ride is a good fit if you:</p>' . $list(['Have appointments on the same days each week', 'Want a confirmation before each ride', 'Are a family member or care facility managing someone\'s schedule']),
    'Recurring ride questions'],
];
foreach ($c as $slug => [$sub, $who, $faq]) {
  $p = get_page_by_path($slug, OBJECT, 'services');
  if (!$p) { $log['missing'][] = $slug; continue; }
  update_post_meta($p->ID, 'hero_subhead', $sub);
  update_post_meta($p->ID, 'who_for', $who);
  update_post_meta($p->ID, 'faq_heading', $faq);
  $log['content'][] = $p->ID;
}
return $log;
