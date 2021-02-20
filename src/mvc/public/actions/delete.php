<?php

$all = $ctrl->db->rselectAll('bbn_medias', ['name', 'old_url', 'content']);
$root = $ctrl->contentPath('appui-note').'media';
die(var_dump($root, is_dir($root)));
foreach ($all as $a) {
  if (!empty($a['content'])) {
    $c = json_decode($a['content'], true);
    
  }
}
$ctrl->action();
