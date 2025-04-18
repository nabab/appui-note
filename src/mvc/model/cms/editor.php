<?php
/**
 * What is my purpose?
 *
 **/

/** @var bbn\Mvc\Model $model */

if ($model->hasData('id', true)) {
  $note = new bbn\Appui\Note($model->db);
  $cms = new bbn\Appui\Cms($model->db, $note);
  $data = $cms->get($model->data['id']);
  if (!empty($data['medias'])) {
    $data['medias'] = array_map(function($m){
      $files = \bbn\File\Dir::getFiles(BBN_PUBLIC . dirname($m['url']));
      $m['cacheFiles'] = $files ? array_map(function($f){
        return [
          'file' => str_replace(BBN_PUBLIC, '', $f),
          'name' => basename($f),
          'modified' => filemtime($f)
        ];
      }, $files) : [];
      return $m;
    }, $data['medias']);
  }
  unset($data['content']);
  return [
    'data' => $data,
    'types' => $note->getOptions('types'),
    'title' => $data['title']
  ];
}
