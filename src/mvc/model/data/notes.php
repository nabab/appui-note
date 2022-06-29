<?php
/*
 * Describe what it does!
 *
 **/

/** @var $model \bbn\mvc\model*/

use bbn\Appui\Note;

$note = new Note($model->db);
return $note->browse($model->data);
