<?php
/*
 *  Describe what it does
 *
 **/
use bbn\X;

$rows = $ctrl->db->rselectAll('bbn_notes_versions', ['version', 'id_note', 'content']);
$fn = function(&$block) {
  $isChanged = false;
  switch($block['type']) {
    case 'button':
    case 'text':
      if (isset($block['text'])) {
        $content = $block['text'];
        unset($block['text']);
        $block['content'] = $content;
        $isChanged = true;
      }
      break;
    case 'carousel':
    case 'gallery':
    case 'image':
    case 'imagetext':
    case 'video':
      if (isset($block['source'])) {
        $content = $block['source'];
        unset($block['source']);
        $block['content'] = $content;
        $isChanged = true;
      }
      break;
  }
  if (isset($block['style'])) {
    $isChanged = true;
    foreach($block['style'] as $name => $value) {
      $block[$name] = $value;
    }
    unset($block['style']);
  }
  return $isChanged;
};

foreach($rows as $row) {
  $blocks = json_decode($row['content'], true);
  $isChanged = false;
  foreach($blocks as &$block) {
		if ($block['type'] === 'container') {
      foreach($block['items'] as &$item) {
        if ($fn($item)) {
          $isChanged = true;
        }
      }
    }
    else {
      if ($fn($block)) {
        $isChanged = true;
      };
    }
  }
  if ($isChanged) {
    X::hdump($ctrl->db->update('bbn_notes_versions', ['content' => json_encode($blocks)], ['id_note' => $row['id_note'], 'version' => $row['version']]));
  }
}
