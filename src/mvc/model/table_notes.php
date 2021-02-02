<?php

if ( !empty($model->data['limit']) ){
  $notes = new \bbn\Appui\Note($model->db);
  return $notes->browse($model->data);
}
return [];