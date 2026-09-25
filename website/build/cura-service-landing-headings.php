<?php
// Cura service landing pages, step 3 (2026-09-24): per-service H2s and area copy so the 9 service pages don't share
// the same three section headings. Adds who_heading, how_heading, area_heading (text) and area_text (wysiwyg) to
// "Service Content" (1337) and fills them. The 3 booking steps stay shared (the process is the same for every ride).
// Template wiring is in cura-service-landing-template.php (re-run it after this file). Idempotent.
$log = [];
$base = ['required' => false, 'disabled' => false, 'readonly' => false, 'clone' => false, 'clone_empty_start' => false,
  'hide_from_rest' => false, 'hide_from_front' => false, 'save_field' => true];
$new = [
  'who_heading' => array_merge($base, ['name' => 'Who it is for: heading', 'id' => 'who_heading', 'type' => 'text', 'desc' => 'H2 above "Who it is for", e.g. "Who our dialysis rides are for". Falls back to "Who this ride is for".']),
  'how_heading' => array_merge($base, ['name' => 'How it works: heading', 'id' => 'how_heading', 'type' => 'text', 'desc' => 'H2 above the 3 booking steps, e.g. "How to set up dialysis rides". Falls back to "How booking a ride works".']),
  'area_heading' => array_merge($base, ['name' => 'Service area: heading', 'id' => 'area_heading', 'type' => 'text', 'desc' => 'H2 for the service-area section, e.g. "Dialysis rides across the Baton Rouge area".']),
  'area_text' => array_merge($base, ['name' => 'Service area: text', 'id' => 'area_text', 'type' => 'wysiwyg', 'raw' => false, 'options' => ['textarea_rows' => 5, 'media_buttons' => false], 'desc' => 'Service-area paragraph for this ride. Do not name towns or clinics until coverage is confirmed.']),
];
$mb = get_post_meta(1337, 'meta_box', true);
$bf = get_post_meta(1337, 'fields', true);
$ordered = [];
foreach ($mb['fields'] as $f) {
  if (isset($new[$f['id']])) continue; // re-added below in place
  if ($f['id'] === 'who_for') $ordered[] = $new['who_heading'];
  $ordered[] = $f;
  if ($f['id'] === 'who_for') { $ordered[] = $new['how_heading']; $ordered[] = $new['area_heading']; $ordered[] = $new['area_text']; }
}
$mb['fields'] = $ordered; $mb['modified'] = time();
$newBf = [];
foreach ($ordered as $f) { $b = isset($new[$f['id']]) ? $new[$f['id']] : ($bf[$f['id']] ?? $f); $b['_id'] = $f['id']; $newBf[$f['id']] = $b; }
update_post_meta(1337, 'meta_box', $mb);
update_post_meta(1337, 'fields', $newBf);
$log['fields'] = array_column($ordered, 'id');

$call = 'Call <a href="tel:+12253630845">(225) 363-0845</a>';
$price = '<p>You get a clear price before any ride is booked. <a href="/rates/">See how our pricing works</a>.</p>';
$c = [
  'doctor-appointment-rides' => ['Who our doctor visit rides are for', 'How to book a ride to the doctor', 'Doctor visit rides across the Baton Rouge area',
    "<p>We drive riders to doctor's offices, specialists, labs and imaging centers across Baton Rouge and nearby communities. Not sure we cover your address? $call and ask.</p>"],
  'dialysis-transportation' => ['Who our dialysis rides are for', 'How to set up dialysis rides', 'Dialysis rides across the Baton Rouge area',
    "<p>We drive riders to dialysis centers across Baton Rouge and nearby communities, on the days and times their treatment is scheduled. Not sure we cover your address or center? $call and ask.</p>"],
  'wheelchair-transportation' => ['Who our wheelchair rides are for', 'How to book a wheelchair ride', 'Wheelchair transportation across the Baton Rouge area',
    "<p>We give rides to people who use a wheelchair, walker or scooter across Baton Rouge and nearby communities, from home or a care facility. Tell us about your mobility needs when you book. Not sure we cover your address? $call and ask.</p>"],
  'hospital-discharge-rides' => ['Who our hospital discharge rides are for', 'How to book a ride home from the hospital', 'Hospital discharge rides across the Baton Rouge area',
    "<p>We pick riders up from hospitals and surgery centers across Baton Rouge and nearby communities and bring them home. Not sure we cover your hospital or address? $call and ask.</p>"],
  'treatment-and-therapy-rides' => ['Who our treatment and therapy rides are for', 'How to book rides to treatment', 'Treatment and therapy rides across the Baton Rouge area',
    "<p>We drive riders to cancer centers, infusion clinics, physical therapy and wound care across Baton Rouge and nearby communities. Not sure we cover your address? $call and ask.</p>"],
  'senior-and-everyday-rides' => ['Who our senior and everyday rides are for', 'How to book an everyday ride', 'Senior transportation across the Baton Rouge area',
    "<p>We give seniors safe rides to the grocery store, the pharmacy and family visits across Baton Rouge and nearby communities. Not sure we cover your address? $call and ask.</p>"],
  'prescription-pickup-and-delivery' => ['Who prescription pickups are for', 'How to set up a prescription pickup', 'Prescription pickups across the Baton Rouge area',
    "<p>We give rides to pharmacies, and pick up and deliver prescriptions, across Baton Rouge and nearby communities. Not sure we cover your pharmacy or address? $call and ask.</p>"],
  'long-distance-medical-transportation' => ['Who our long-distance rides are for', 'How to plan a long-distance medical trip', 'Long-distance trips from the Baton Rouge area',
    "<p>We pick riders up across Baton Rouge and nearby communities and drive them to specialists and hospitals farther away. Tell us the destination and appointment time, and we will plan the trip with you. $call to ask about a trip.</p>"],
  'recurring-rides' => ['Who recurring rides are for', 'How to set up a recurring ride schedule', 'Recurring rides across the Baton Rouge area',
    "<p>We set up standing rides to dialysis, therapy and treatment across Baton Rouge and nearby communities. Not sure we cover your address? $call and ask.</p>"],
];
foreach ($c as $slug => [$who, $how, $areaH, $areaT]) {
  $p = get_page_by_path($slug, OBJECT, 'services');
  if (!$p) { $log['missing'][] = $slug; continue; }
  update_post_meta($p->ID, 'who_heading', $who);
  update_post_meta($p->ID, 'how_heading', $how);
  update_post_meta($p->ID, 'area_heading', $areaH);
  update_post_meta($p->ID, 'area_text', $areaT . $price);
  $log['content'][] = $p->ID;
}
return $log;
