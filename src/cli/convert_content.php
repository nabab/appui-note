<?php
/*
 *  Describe what it does
 *
 **/
use bbn\X;

$q = $ctrl->db->query("SELECT version, id_note, content FROM bbn_notes_versions");
$fn = function(&$block) {
  $isChanged = false;
  $content = false;
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
    case 'product':
      if (array_key_exists('id_product', $block)) {
        if (!empty($block['id_product'])) {
          $content = $block['id_product'];
        }
        unset($block['id_product']);
        $isChanged = true;
      }
      if (array_key_exists('product', $block)) {
        if (!empty($block['product']['id'])
          && empty($content)
        ) {
          $content = $block['product']['id'];
        }
        unset($block['product']);
        $isChanged = true;
      }
      if ($isChanged) {
        $block['content'] = $content ?: null;
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
