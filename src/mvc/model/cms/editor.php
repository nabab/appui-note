<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('id', true)) {
  $note = new bbn\Appui\Note($model->db);
  $cms = new bbn\Appui\Cms($model->db, $note);
  $data = $cms->get($model->data['id']);
  $data['items'] = $data['content'] ? json_decode($data['content']) : [];
  if (!empty($data['medias'])) {
    $data['medias'] = array_map(function($m){
      $m['cacheFiles'] = array_map(function($f){
        return [
          'file' => str_replace(BBN_PUBLIC, '', $f),
          'name' => basename($f),
          'modified' => filemtime($f)
        ];
      }, \bbn\File\Dir::getFiles(BBN_PUBLIC . dirname($m['url'])));
      return $m;
    }, $data['medias']);
  }
  unset($data['content']);
  return ['data' => $data, 'types' => $note->getOptions('types'), 'title' => $data['title']];
}
