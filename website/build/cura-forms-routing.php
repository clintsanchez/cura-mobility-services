<?php
// Cura form routing (2026-09-24): every WS form emails Michael (mveal72@yahoo.com) and redirects to its own
// confirmation page. Creates the "Email updates" confirmation and a separate "Free estimate" form (clone of Request
// Quote) so /forms/estimate/ lands on /confirmation/estimate/. Only form-level action meta is changed (never fields).
// Idempotent.
global $wpdb;
$TO = 'mveal72@yahoo.com';
$log = [];

// 1. "Email updates" confirmation (footer sign-up).
$ex = get_posts(['post_type' => 'confirmation', 'name' => 'email-updates', 'post_status' => 'any', 'numberposts' => 1]);
$cid = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'confirmation', 'post_status' => 'publish', 'post_title' => 'Email updates', 'post_name' => 'email-updates', 'post_author' => 1]);
update_post_meta($cid, 'conf_h1', 'Thanks. You are on the list.');
update_post_meta($cid, 'conf_content', '<p>You are signed up for ride tips and service updates from Cura Mobility Services. You can unsubscribe at any time.</p>' . "\n\n" . '<p>Need a ride? Call <a href="tel:+12253630845">(225) 363-0845</a> or request a ride online. For a medical emergency, call 911.</p>');
$log['email_updates_confirmation'] = $cid;

// 2. "Free estimate" form: clone Request Quote (form 1) once, then point the Free estimate form post at it.
$estId = (int) $wpdb->get_var("SELECT id FROM {$wpdb->prefix}wsf_form WHERE label='Free estimate' AND status<>'trash' LIMIT 1");
if (!$estId) {
  $c = new WS_Form_Form(); $c->id = 1; $c->label = 'Free estimate'; $c->db_clone();
  $estId = (int) $c->id;
  $wpdb->update("{$wpdb->prefix}wsf_form", ['label' => 'Free estimate'], ['id' => $estId]);
}
$estPost = get_posts(['post_type' => 'forms', 'name' => 'estimate', 'numberposts' => 1]);
if ($estPost) wp_update_post(['ID' => $estPost[0]->ID, 'post_content' => '[ws_form id="' . $estId . '"]']);
$log['estimate_form'] = $estId;

// 3. Routing table: form id => confirmation slug.
$routes = [1 => 'quote', 2 => 'appointment', 3 => 'email-updates', 5 => 'consultation', $estId => 'estimate'];
foreach (['Ride request' => 'ride-request', 'Contact us' => 'contact'] as $label => $slug) {
  $id = (int) $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}wsf_form WHERE label=%s AND status<>'trash' LIMIT 1", $label));
  if ($id) $routes[$id] = $slug;
}

// A redirect action row to copy (from Request Quote).
$q = new WS_Form_Form(); $q->id = 1; $qo = $q->db_read(true, false);
$redirectRow = null; foreach ($qo->meta->action->groups[0]->rows as $r) { $d = json_decode($r->data[1]); if ($d->id === 'redirect') $redirectRow = $r; }

foreach ($routes as $fid => $slug) {
  $f = new WS_Form_Form(); $f->id = $fid; $o = $f->db_read(true, false);
  $rows = []; $hasRedirect = false; $maxId = 0;
  foreach ($o->meta->action->groups[0]->rows as $r) $maxId = max($maxId, (int) $r->id);
  foreach ($o->meta->action->groups[0]->rows as $r) {
    $d = json_decode($r->data[1]);
    if ($d->id === 'message') continue;                       // replaced by the confirmation page
    if ($d->id === 'redirect') { $d->meta->action_redirect_url = "/confirmation/$slug/"; $hasRedirect = true; }
    if ($d->id === 'email') {
      $d->meta->action_email_to = [(object) ['action_email_email' => $TO, 'action_email_name' => 'Michael Veal']];
      if (empty($d->meta->action_email_from_name) || $d->meta->action_email_from_name === '#blog_name') $d->meta->action_email_from_name = 'Cura website';
    }
    $r->data[1] = wp_json_encode($d); $rows[] = $r;
  }
  if (!$hasRedirect && $redirectRow) {
    $n = json_decode(wp_json_encode($redirectRow)); $n->id = ++$maxId;
    $nd = json_decode($n->data[1]); $nd->meta->action_redirect_url = "/confirmation/$slug/"; $n->data[1] = wp_json_encode($nd);
    $rows[] = $n;
  }
  $o->meta->action->groups[0]->rows = array_values($rows);
  $m = new WS_Form_Meta(); $m->object = 'form'; $m->parent_id = $fid; $m->db_update_from_object((object) ['action' => $o->meta->action]);
  $p = new WS_Form_Form(); $p->id = $fid; $p->db_publish();

  // Read back for the log.
  $chk = new WS_Form_Form(); $chk->id = $fid; $co = $chk->db_read(true, false); $sum = [];
  foreach ($co->meta->action->groups[0]->rows as $r) { $d = json_decode($r->data[1]); $sum[] = $d->id === 'redirect' ? 'redirect ' . $d->meta->action_redirect_url : ($d->id === 'email' ? 'email ' . implode(',', array_map(fn($t) => $t->action_email_email, (array) $d->meta->action_email_to)) : $d->id); }
  $log['forms'][$fid . ' ' . $co->label] = $sum;
}
return $log;
