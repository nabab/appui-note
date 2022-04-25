<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/
//return $model->getSetFromCache(function() use ($model){
  $types_notes = $model->inc->options->fullOptions('types', 'note', 'appui');
  $res = [];
  $url = $model->pluginUrl('appui-note') . '/cms/data/widget/';
  foreach ($types_notes as $t) {
    $res[] = [
      'title' => $t['text'],
      'itemComponent' => 'appui-note-widget-cms',
      'url' => $url . $t['id'],
      'uid' => $t['id']
    ];
  }
  return [
    'types_notes' => $res
  ];
//}, [], 'notes-cms-data', 120);
