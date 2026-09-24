<?php
// Cura: "Ride request" WS Form, a copy of the Breakdance ride-request form (Home 158 / Book a ride / FAQs):
// same fields, placeholders, options, required flags, row layout (4/4/4, 4/4/4, 6/6), success message and email.
// Built through WS Form's API from the Newsletter form's object (keeps all form-level meta). Idempotent by label.
$LABEL = 'Ride request';
$log = [];

// Existing? (re-run updates it in place)
global $wpdb;
$existing = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}wsf_form WHERE label=%s AND status<>'trash' LIMIT 1", $LABEL));

$field = function ($type, $label, array $meta) {
  $f = new stdClass(); $f->type = $type; $f->label = $label;
  $f->meta = (object) array_merge(['label_render' => '', 'aria_label' => $label, 'breakpoint_size_25' => '12'], $meta);
  return $f;
};
$grid = function (array $options) {
  $rows = []; foreach ($options as $i => $o) $rows[] = ['id' => $i + 1, 'default' => '', 'disabled' => '', 'required' => '', 'hidden' => '', 'data' => [$o]];
  return json_decode(wp_json_encode(['rows_per_page' => 10, 'group_index' => 0, 'default' => [], 'columns' => [['id' => 0, 'label' => 'Option']], 'groups' => [['label' => 'Options', 'page' => 0, 'disabled' => '', 'mask_group' => '', 'rows' => $rows]]]));
};
$third = ['breakpoint_size_75' => '4'];
$half = ['breakpoint_size_75' => '6'];
$fields = [
  $field('text', "Rider's name", $third + ['placeholder' => "Rider's name", 'required' => 'on', 'autocomplete' => 'name']),
  $field('email', 'Your email', $third + ['placeholder' => 'Your email', 'required' => 'on', 'autocomplete' => 'email']),
  $field('tel', 'Your phone', $third + ['placeholder' => 'Your phone', 'required' => 'on', 'autocomplete' => 'tel']),
  $field('select', 'Mobility needs', $third + ['placeholder_row' => 'Mobility needs', 'select_field_label' => '0', 'select_field_value' => '0',
    'data_grid_select' => $grid(['Walks on their own', 'Uses a cane or walker', 'Uses a wheelchair', 'Bariatric or scooter'])]),
  $field('select', 'Trip type', $third + ['placeholder_row' => 'Trip type', 'select_field_label' => '0', 'select_field_value' => '0',
    'data_grid_select' => $grid(['One way', 'Round trip', 'Recurring rides (dialysis or treatment)'])]),
  $field('datetime', 'Appointment date', $third + ['input_type_datetime' => 'date', 'placeholder' => 'Appointment date']),
  $field('text', 'Pickup address', $half + ['placeholder' => 'Pickup address', 'autocomplete' => 'street-address']),
  $field('text', 'Destination (clinic, hospital or office)', $half + ['placeholder' => 'Destination (clinic, hospital or office)']),
  $field('hidden', 'Requested from', ['default_value' => '#post_title', 'breakpoint_size_25' => '12']), // which page the request came from
  $field('submit', 'Request my ride', ['breakpoint_size_25' => '12', 'label_render' => 'on']), // label = button text, must render
];

// Base object: Newsletter Signup (form 3) has the message action we want; strip ids so everything is created new.
$base = new WS_Form_Form(); $base->id = 3; $obj = $base->db_read(true, true);
// Strip ids at the form/group/section level only (NOT inside meta: data grids need their column/row ids).
$strip = function (&$o) { unset($o->id); foreach ($o->groups as $g) { unset($g->id, $g->form_id); foreach ($g->sections as $sec) { unset($sec->id, $sec->group_id); } } };
$obj->label = $LABEL;
$obj->groups = [$obj->groups[0]];
$obj->groups[0]->sections = [$obj->groups[0]->sections[0]];
$obj->groups[0]->sections[0]->fields = $fields;
$strip($obj);

// Rebuild cleanly on re-run: delete the old form permanently (separate object), then create from a fresh one.
foreach ($wpdb->get_col($wpdb->prepare("SELECT id FROM {$wpdb->prefix}wsf_form WHERE label=%s", $LABEL)) as $oldId) { $del = new WS_Form_Form(); $del->id = (int) $oldId; $del->db_delete(true); }
$wf = new WS_Form_Form();
$wf->db_update_from_object($obj, true, true);
$fid = $wf->id;

// Field ids -> actions (reply-to rider email, subject with rider name)
$read = new WS_Form_Form(); $read->id = $fid; $o = $read->db_read(true, true);
$ids = []; foreach ($o->groups[0]->sections[0]->fields as $f) $ids[$f->label] = $f->id;
$act = $o->meta->action;
foreach ($act->groups[0]->rows as $r) {
  $d = json_decode($r->data[1]);
  if ($d->id === 'message') { // Redirect to the ride-request confirmation page instead (2026-09-24)
    $q = new WS_Form_Form(); $q->id = 1; $qo = $q->db_read(true, false);
    foreach ($qo->meta->action->groups[0]->rows as $qr) { $qd = json_decode($qr->data[1]); if ($qd->id === 'redirect') { $qd->meta->action_redirect_url = '/confirmation/ride-request/'; $r->data[0] = 'Confirmation Page'; $d = $qd; } }
  }
  if ($d->id === 'email') {
    $d->meta->action_email_to = [(object) ['action_email_email' => 'clint@blaksheepcreative.com', 'action_email_name' => 'Cura ride requests']];
    $d->meta->action_email_from_name = 'Cura ride request';
    $d->meta->action_email_reply_to_email = '#field(' . $ids['Your email'] . ')';
    $d->meta->action_email_subject = "New ride request from #field(" . $ids["Rider's name"] . ')';
  }
  $r->data[1] = wp_json_encode($d);
}
$meta = new WS_Form_Meta(); $meta->object = 'form'; $meta->parent_id = $fid; $meta->db_update_from_object((object) ['action' => $act]);
$pub = new WS_Form_Form(); $pub->id = $fid; $pub->db_publish();

// Native browser date input (matches the Breakdance form); WS Form global setting, affects all WS forms.
WS_Form_Common::option_set('ui_datepicker', 'native');
$log['form_id'] = $fid; $log['fields'] = $ids; $log['shortcode'] = '[ws_form id="' . $fid . '"]';
return $log;
