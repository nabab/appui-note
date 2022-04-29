<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

$types_notes = $model->inc->options->fullOptions('types', 'note', 'appui');
$cms = $model->inc->options->fromCode('bbn-cms', 'editors', 'note', 'appui');
$res = [];
$url = $model->pluginUrl('appui-note') . '/cms/data/widget/';
foreach ($types_notes as $t) {
  if ($t['id_alias'] === $cms) {
    $res[] = [
      'title' => $t['text'],
      'code' => $t['code'],
      'itemComponent' => 'appui-note-widget-cms',
      'url' => $url . $t['id'],
      'uid' => $t['id']
    ];
  }
}
return [
  'root' => $model->data['root'],
  'types_notes' => $res
];
