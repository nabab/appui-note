<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
/** @var $model \bbn\Mvc\Model*/

return [
  'blocks' => $model->inc->options->fullOptions("blocks", "note", "appui"),
  'pblocks' => $model->inc->options->fullOptionsRef("pblocks", "note", "appui")
];
