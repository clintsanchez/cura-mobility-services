<?php
// Cura build helpers: load/edit/save Breakdance element trees.
if (!function_exists('cura_bd_load')) {
function cura_bd_load($post_id) {
    $j = json_decode(get_post_meta($post_id, '_breakdance_data', true), true);
    return [$j, json_decode($j['tree_json_string'], true)];
}
function cura_bd_save($post_id, $j, $tree) {
    $j['tree_json_string'] = wp_json_encode($tree);
    update_post_meta($post_id, '_breakdance_data', wp_slash(wp_json_encode($j)));
    try { if (function_exists('Breakdance\Render\generateCacheForPost')) \Breakdance\Render\generateCacheForPost($post_id); elseif (function_exists('Breakdance\Data\regenerate_post_cache')) \Breakdance\Data\regenerate_post_cache($post_id); } catch (\Throwable $e) { error_log('cura_bd_save cache: '.$e->getMessage()); }
    return true;
}
function &cura_bd_node(&$node, $id) {
    $null = null;
    if (($node['id'] ?? null) == $id) return $node;
    if (!empty($node['children'])) {
        foreach ($node['children'] as $k => &$c) { $r = &cura_bd_node($c, $id); if ($r !== null) return $r; unset($r); }
    }
    return $null;
}
function cura_bd_set(&$tree, $id, $path, $value) {
    $n = &cura_bd_node($tree['root'], $id);
    if ($n === null) return false;
    if (!isset($n['data']['properties']) || !is_array($n['data']['properties'])) $n['data']['properties'] = [];
    $ref = &$n['data']['properties'];
    foreach (explode('.', $path) as $p) { if (!isset($ref[$p]) || !is_array($ref[$p])) $ref[$p] = []; $ref = &$ref[$p]; }
    $ref = $value;
    return true;
}
function cura_bd_get(&$tree, $id, $path = '') {
    $n = &cura_bd_node($tree['root'], $id);
    if ($n === null) return null;
    $ref = $n['data']['properties'] ?? [];
    if ($path === '') return $ref;
    foreach (explode('.', $path) as $p) { if (!isset($ref[$p])) return null; $ref = $ref[$p]; }
    return $ref;
}
function cura_bd_remove(&$node, $id) {
    if (empty($node['children'])) return false;
    foreach ($node['children'] as $k => $c) {
        if (($c['id'] ?? null) == $id) { array_splice($node['children'], $k, 1); return true; }
        if (cura_bd_remove($node['children'][$k], $id)) return true;
    }
    return false;
}
function cura_bd_outline($node, $d = 0, &$out = []) {
    $t = $node['data']['type'] ?? 'root'; $c = $node['data']['properties']['content'] ?? [];
    $s = '';
    array_walk_recursive($c, function($v, $k) use (&$s) {
        if (is_string($v) && !in_array($k, ['svgCode','srcset','sizes','shortcode','orientation','mime','type','slug','iconSetSlug'], true) && strlen(trim(strip_tags($v))) && strlen($v) < 600)
            $s .= $k . '=' . mb_substr(trim(strip_tags($v)), 0, 60) . ' | ';
    });
    $parts = explode('\\', $t);
    $out[] = str_repeat('  ', $d) . '#' . ($node['id'] ?? '') . ' ' . end($parts) . ' ' . mb_substr($s, 0, 260);
    foreach ($node['children'] ?? [] as $ch) cura_bd_outline($ch, $d + 1, $out);
    return $out;
}
function cura_upload($path, $title, $alt) {
    require_once ABSPATH.'wp-admin/includes/file.php'; require_once ABSPATH.'wp-admin/includes/media.php'; require_once ABSPATH.'wp-admin/includes/image.php';
    $ex = get_posts(['post_type'=>'attachment','post_status'=>'inherit','numberposts'=>1,'meta_key'=>'_cura_source','meta_value'=>$path]);
    if ($ex) return $ex[0]->ID;
    $tmp = wp_tempnam(basename($path)); copy($path, $tmp);
    $id = media_handle_sideload(['name'=>basename($path),'tmp_name'=>$tmp], 0, $title);
    if (is_wp_error($id)) return $id;
    update_post_meta($id, '_wp_attachment_image_alt', $alt); update_post_meta($id, '_cura_source', $path);
    return $id;
}
function cura_bd_image($id) {
    $m = wp_get_attachment_metadata($id); $url = wp_get_attachment_url($id); $sizes = [];
    foreach (($m['sizes'] ?? []) as $k => $s) { $sizes[$k] = ['height'=>$s['height'],'width'=>$s['width'],'url'=>dirname($url).'/'.$s['file'],'orientation'=>$s['width']>=$s['height']?'landscape':'portrait']; }
    $sizes['full'] = ['url'=>$url,'height'=>$m['height']??0,'width'=>$m['width']??0,'orientation'=>(($m['width']??0)>=($m['height']??0))?'landscape':'portrait'];
    return ['id'=>$id,'filename'=>basename($url),'url'=>$url,'alt'=>get_post_meta($id,'_wp_attachment_image_alt',true),'caption'=>'','mime'=>get_post_mime_type($id),'type'=>'image','sizes'=>$sizes,'attributes'=>['srcset'=>wp_get_attachment_image_srcset($id,'full') ?: '','sizes'=>wp_get_attachment_image_sizes($id,'full') ?: '']];
}

function cura_bd_types($node, &$out = []) { $out[] = $node['data']['type'] ?? 'root'; foreach ($node['children'] ?? [] as $c) cura_bd_types($c, $out); return $out; }
/** Copy content + background images from $src subtree onto $dst subtree when structures match. */
function cura_bd_copy_into(&$dst, $src) {
    $dst['data']['properties']['content'] = $src['data']['properties']['content'] ?? ($dst['data']['properties']['content'] ?? null);
    if ($dst['data']['properties']['content'] === null) unset($dst['data']['properties']['content']);
    $bg = $src['data']['properties']['design']['background']['image'] ?? null;
    if ($bg !== null) $dst['data']['properties']['design']['background']['image'] = $bg;
    foreach (['typography','button'] as $k) { /* keep dst design except explicit fixes below */ }
    $srcIcon = $src['data']['properties']['design']['button']['custom']['icon']['icon'] ?? null;
    if ($srcIcon !== null) $dst['data']['properties']['design']['button']['custom']['icon']['icon'] = $srcIcon;
    if (isset($src['data']['properties']['settings']['advanced']['draft'])) $dst['data']['properties']['settings']['advanced']['draft'] = $src['data']['properties']['settings']['advanced']['draft'];
    if (!empty($dst['children'])) { foreach ($dst['children'] as $i => &$c) { if (isset($src['children'][$i])) cura_bd_copy_into($c, $src['children'][$i]); } unset($c); }
}
function cura_bd_copy_section(&$dstTree, $dstId, $srcTree, $srcId) {
    $d = &cura_bd_node($dstTree['root'], $dstId); $s = &cura_bd_node($srcTree['root'], $srcId);
    if ($d === null || $s === null) return "missing $dstId/$srcId";
    $a = cura_bd_types($d); $b = cura_bd_types($s);
    if ($a !== $b) return "mismatch $dstId<-$srcId: " . count($a) . ' vs ' . count($b);
    cura_bd_copy_into($d, $s); return true;
}

/** Dynamic-data binding object for a Breakdance field slug (e.g. post_title, post_permalink). */
function cura_bd_dyn($slug, $attrs = []) {
    $c = \Breakdance\DynamicData\DynamicDataController::getInstance();
    $f = null; foreach ($c->fields as $x) if ($x->slug() === $slug) { $f = $x; break; }
    if (!$f) throw new \Exception("no dynamic field $slug");
    $a = ''; foreach ($attrs as $k => $v) $a .= " $k='$v'";
    $sc = "[breakdance_dynamic field='$slug'$a]";
    return ['shortcode' => $sc, 'meta' => ['field' => ['category' => $f->category(), 'subcategory' => method_exists($f, 'subcategory') ? $f->subcategory() : '', 'label' => $f->label(), 'slug' => $slug, 'returnTypes' => $f->returnTypes(), 'defaultAttributes' => method_exists($f, 'defaultAttributes') ? $f->defaultAttributes() : [], 'proOnly' => method_exists($f, 'proOnly') ? $f->proOnly() : false], 'shortcode' => $sc, 'attributes' => $attrs]];
}
/** Give a copied subtree fresh node ids from $tree['_nextNodeId']. */
function cura_bd_reid(&$node, &$tree) {
    $node['id'] = $tree['_nextNodeId']++;
    if (!empty($node['children'])) { foreach ($node['children'] as &$c) cura_bd_reid($c, $tree); unset($c); }
}
function cura_bd_el($type, $props = [], $children = []) {
    return ['id' => 0, 'data' => ['type' => 'EssentialElements\\' . $type, 'properties' => $props], 'children' => $children];
}
/** Create/update a Breakdance global block from a list of top-level nodes. Returns post id. */
function cura_bd_block($title, $nodes) {
    $ex = get_posts(['post_type' => 'breakdance_block', 'title' => $title, 'post_status' => 'any', 'numberposts' => 1]);
    $id = $ex ? $ex[0]->ID : wp_insert_post(['post_type' => 'breakdance_block', 'post_status' => 'publish', 'post_title' => $title]);
    $tree = ['root' => ['id' => 1, 'data' => ['type' => 'root', 'properties' => []], 'children' => $nodes], '_nextNodeId' => 100, 'status' => 'exported'];
    foreach ($tree['root']['children'] as &$n) cura_bd_reid($n, $tree); unset($n);
    cura_bd_save($id, ['tree_json_string' => ''], $tree);
    return $id;
}
}
