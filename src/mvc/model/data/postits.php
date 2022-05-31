<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
use bbn\Appui\Note;
/** @var $model \bbn\Mvc\Model*/

$notes = new Note($model->db);
return ['data' => $notes->getPostIts(50, 0, $model->hasData('pinned', true))];
