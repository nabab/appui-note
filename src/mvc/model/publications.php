<?php
  $all = [
    'data' => [],
    'total' => 0
  ];

  if ( !empty($model->data['limit']) ){
    $notes = new \bbn\Appui\Note($model->db);
    $type = $model->inc->options->fromCode('pages', 'types', 'note', 'appui');

    $all['data'] = array_map(function($note)use($model){
      $note['url'] = $model->db->rselect('bbn_notes_url', ['url'], [ 'id_note' => $note['id_note'] ])['url'];
      $note['content'] = \bbn\Str::cut($note['content'], 100);
      return $note;
    }, $notes->getByType($type));

    $all['total'] = $notes->countByType($type);
  }
return $all;