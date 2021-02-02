<?php
$res = [
  'success' => false
];
$notes = new \bbn\Appui\Note($model->db);
if ( !empty($model->data['id_note']) ){
  $res['success'] = $notes->remove($model->data['id_note'], !empty($model->data['keep']));
}
return $res;
