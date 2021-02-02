<?php
$notes = new \bbn\Appui\Note($model->db);
$res = $notes->browse(['limit' => 25]);
if ( $res ){
  return ['notes' => $res['data']];
}
return [
  'notes' => false
];