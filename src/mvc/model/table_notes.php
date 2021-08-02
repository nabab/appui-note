<?php

use \bbn\Appui\Note;
if ( !empty($model->data['limit']) ){
  $notes = new Note($model->db);
  return $notes->browse($model->data);
}
return ['options' => Note::getOptionsTextValue('types')];
