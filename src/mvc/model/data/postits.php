<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
use bbn\Appui\Note;
/** @var bbn\Mvc\Model $model */

$notes = new Note($model->db);
return ['data' => $notes->getPostIts(['limit' => 50, 'start' => 0], $model->hasData('pinned', true))];
