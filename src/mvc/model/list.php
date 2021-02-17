<?php
/*
 * Describe what it does!
 *
 **/

/** @var $model \bbn\mvc\model*/
if ($id_types = $model->inc->options->fromCode('types', 'note', 'appui')) {
  return [
    'types' => $model->inc->options->textValueOptions($id_types),
    'root' => APPUI_NOTE_ROOT
  ];
}
