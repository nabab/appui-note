<?php
use bbn\Appui\Note;
use bbn\Str;

if (!empty($model->data['id_note'])
  && !empty($model->data['version'])
  && ($notes = new Note($model->db))
  && ($version = $notes->getFull($model->data['id_note'], $model->data['version']))
  && ($ftype = $model->inc->options->fromCode('file', 'media', 'note', 'appui'))
  && ($ltype = $model->inc->options->fromCode('link', 'media', 'note', 'appui'))
){
  $version['name'] = $model->db->selectOne('bbn_notes_masks', 'name', ['id_note' => $version['id']]);
  $version['files'] = [];
  $version['links'] = [];
  foreach ($version['medias'] as $m) {
    if ($m['type'] === $ftype) {
      $version['files'][] = [
        'id' => $m['id'],
        'name' => $m['name'],
        'title' => $m['title'],
        'extension' => '.' . Str::fileExt($m['name'])
      ];
    }
    if ($m['type'] === $ltype) {
      $version['links'][] = $m;
    }
  }
  unset($version['medias']);
  return [
    'success' => true,
    'data' => $version
  ];
}

return ['success' => false];
