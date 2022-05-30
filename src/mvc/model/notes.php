<?php
use bbn\Str;

$notes = new \bbn\Appui\Note($model->db);
$id_type = $model->inc->options->fromCode('postit', 'types', 'note', 'appui');
$res = $notes->browse(['limit' => 25], true, true, $id_type);
if ( $res ){
  return ['notes' => array_map(function($a) {
    if (Str::isJson($a['content'])) {
      return array_merge($a, json_decode($a['content'], true));
    }
    unset($a['content']);
    return $a;
  }, $res['data']), 'query' => $model->db->last()];
}
return [
  'notes' => false
];