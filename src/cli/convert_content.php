<?php
/*
 *  Describe what it does
 *
 **/
use bbn\X;

$q = $ctrl->db->query("SELECT version, id_note, content FROM bbn_notes_versions");
$dimensions = [
  'bbn-xs' => 'xs',
  'bbn-s' => 's',
  'bbn-m' => 'm',
  'bbn-large' => 'lg',
  'bbn-xlarge' => 'xl',
  'bbn-xxlarge' => 'xxl'
];
$padding = [
  'bbn-no-padding' => 'no',
  'bbn-xspadded' => 'xs',
  'bbn-spadded' => 's',
  'bbn-lpadded' => 'l',
  'bbn-xlpadded' => 'xl'
];
$fn = function(&$block) use ($dimensions, $padding) {
  $isChanged = false;
  switch($block['type']) {
    case 'button':
      if (!empty($block['dimensions']) && $dimensions[$block['dimensions']]) {
        $block['dimensions'] = $dimensions[$block['dimensions']];
        $isChanged = true;
      }

      if (!empty($block['padding']) && isset($dimensions[$block['padding']])) {
        unset($block['padding']);
        $block['vpadding'] = $dimensions[$block['padding']];
        $block['hpadding'] = $dimensions[$block['padding']];
        $isChanged = true;
      }

      if (isset($block['text'])) {
        $content = $block['text'];
        unset($block['text']);
        $block['content'] = $content;
        $isChanged = true;
      }

      break;

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
    case 'slider':
      if (isset($block['id_feature'])) {
        $content = $block['id_feature'];
        unset($block['id_feature']);
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

  if (!empty($block['align']) && ($block['align'] === 'left')) {
    unset($block['align']);
    $isChanged = true;
  }

  if (!empty($block['color']) && ($block['color'] === '#000')) {
    unset($block['color']);
    $isChanged = true;
  }

  if (!empty($block['fontStyle']) && ($block['fontStyle'] === 'nomral')) {
    unset($block['fontStyle']);
    $isChanged = true;
  }

  if (!empty($block['textDecoration']) && ($block['textDecoration'] === 'none')) {
    unset($block['textDecoration']);
    $isChanged = true;
  }

  if (isset($block['currentItems'])) {
    $isChanged = true;
    unset($block['currentItems']);
  }
  return $isChanged;
};

while($row = $q->getRow()) {
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
