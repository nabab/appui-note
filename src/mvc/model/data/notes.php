<?php
/*
 * Describe what it does!
 *
 **/

/** @var $model \bbn\mvc\model*/


$note = new bbn\Appui\Note($model->db);
return $note->browse($model->data);
