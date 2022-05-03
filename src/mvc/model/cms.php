<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

$types_notes = $model->inc->options->fullOptions('types', 'note', 'appui');
$cms = $model->inc->options->fromCode('bbn-cms', 'editors', 'note', 'appui');
$res = [];
foreach ($types_notes as $t) {
  if ($t['id_alias'] === $cms) {
    if (!empty($t['id_root_alias'])) {
      $t['options'] = $model->inc->options->textValueOptions($t['id_root_alias']);
    }

    $res[] = $t;
  }
}
return [
  'root' => $model->data['root'],
  'types_notes' => $res
];
