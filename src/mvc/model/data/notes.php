<?php

/** @var $model \bbn\mvc\model*/


$note = new bbn\Appui\Note($model->db);
return $note->browse($model->data);
