<?php
// Cura: "Contact us" WS Form, replacing the Breakdance contact form on the Contact page (186 #118).
// Same fields as that form (Name, Email, Phone, Message; labels shown), plus the blueprint's consent checkbox and a
// hidden "Requested from" field. Saves, emails, redirects to /confirmation/contact/. Rebuilt from scratch on re-run
// (the id changes; update the Contact page shortcode after a re-run).
$LABEL = 'Contact us';
global $wpdb;
$log = [];

// Base: blueprint Contact Us (form 4) if it still exists, else the last build of this form.
$baseId = $wpdb->get_var("SELECT id FROM {$wpdb->prefix}wsf_form WHERE status<>'trash' AND label IN ('Contact Us','Contact us') ORDER BY id LIMIT 1");
$base = new WS_Form_Form(); $base->id = (int) $baseId; $obj = $base->db_read(true, true);

// Keep the consent checkbox object (its option grid needs its ids), give it Cura wording.
$consent = null;
foreach ($obj->groups[0]->sections[0]->fields as $f) if ($f->type === 'checkbox') $consent = $f;
if ($consent) {
  unset($consent->id, $consent->section_id, $consent->sort_index); // keep its place in our field order
  $grid = $consent->meta->data_grid_checkbox ?? null;
  if ($grid && isset($grid->groups[0]->rows[0])) $grid->groups[0]->rows[0]->data[0] = 'I agree that Cura Mobility Services may store my information to respond to my message.';
}

$field = function ($type, $label, array $meta) {
  $f = new stdClass(); $f->type = $type; $f->label = $label;
  $f->meta = (object) array_merge(['label_render' => 'on', 'breakpoint_size_25' => '12'], $meta);
  return $f;
};
$fields = [
  $field('text', 'Name', ['placeholder' => 'Your name', 'required' => 'on', 'autocomplete' => 'name']),
  $field('email', 'Email', ['placeholder' => 'Your email', 'required' => 'on', 'autocomplete' => 'email']),
  $field('tel', 'Phone', ['placeholder' => 'Your phone', 'autocomplete' => 'tel']),
  $field('textarea', 'Message', ['placeholder' => 'How can we help?', 'required' => 'on']),
];
if ($consent) $fields[] = $consent;
$fields[] = $field('hidden', 'Requested from', ['default_value' => '#post_title', 'label_render' => '']);
$fields[] = $field('submit', 'Send message', []);

// Strip ids at the form/group/section level only (field meta and grids keep theirs).
unset($obj->id);
foreach ($obj->groups as $g) { unset($g->id, $g->form_id); foreach ($g->sections as $s) unset($s->id, $s->group_id); }
$obj->label = $LABEL;
$obj->groups = [$obj->groups[0]];
$obj->groups[0]->sections = [$obj->groups[0]->sections[0]];
$obj->groups[0]->sections[0]->fields = $fields;

// Remove any previous build of this form (label "Contact us") before creating the new one.
foreach ($wpdb->get_col($wpdb->prepare("SELECT id FROM {$wpdb->prefix}wsf_form WHERE label=%s", $LABEL)) as $old) { $d = new WS_Form_Form(); $d->id = (int) $old; $d->db_delete(true); }
$wf = new WS_Form_Form(); $wf->db_update_from_object($obj, true, true); $fid = $wf->id;

// Actions: save, email (reply-to the sender), redirect to the contact confirmation.
$read = new WS_Form_Form(); $read->id = $fid; $o = $read->db_read(true, true);
$ids = []; foreach ($o->groups[0]->sections[0]->fields as $f) $ids[$f->label] = $f->id;
foreach ($o->meta->action->groups[0]->rows as $r) {
  $d = json_decode($r->data[1]);
  if ($d->id === 'email') {
    $d->meta->action_email_to = [(object) ['action_email_email' => 'clint@blaksheepcreative.com', 'action_email_name' => 'Cura messages']];
    $d->meta->action_email_from_name = 'Cura website';
    $d->meta->action_email_reply_to_email = '#field(' . $ids['Email'] . ')';
    $d->meta->action_email_subject = 'New message from #field(' . $ids['Name'] . ')';
  }
  if ($d->id === 'redirect') $d->meta->action_redirect_url = '/confirmation/contact/';
  $r->data[1] = wp_json_encode($d);
}
$meta = new WS_Form_Meta(); $meta->object = 'form'; $meta->parent_id = $fid; $meta->db_update_from_object((object) ['action' => $o->meta->action]);
$pub = new WS_Form_Form(); $pub->id = $fid; $pub->db_publish();

// The blueprint form 4 is replaced by this one.
if ($baseId && (int) $baseId !== $fid && $wpdb->get_var($wpdb->prepare("SELECT label FROM {$wpdb->prefix}wsf_form WHERE id=%d", $baseId)) === 'Contact Us') { $d = new WS_Form_Form(); $d->id = (int) $baseId; $d->db_delete(true); }

$log['form_id'] = $fid; $log['fields'] = $ids; $log['shortcode'] = '[ws_form id="' . $fid . '"]';
return $log;
