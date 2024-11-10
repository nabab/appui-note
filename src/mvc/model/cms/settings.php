<?php
/**
 * What is my purpose?
 *
 **/

/** @var bbn\Mvc\Model $model */

$fs = new bbn\File\System();
return [
  'blocks' => array_map('basename', $fs->getDirs($model->libPath() . 'bbn/appui-note/src/components/cms/block')),
  'types' => $model->inc->options->fullOptions('types', 'note', 'appui'),
  'editors' => $model->inc->options->fullOptions('editors', 'note', 'appui'),
  'options' => $model->inc->options->fullTree('note', 'appui')
];
