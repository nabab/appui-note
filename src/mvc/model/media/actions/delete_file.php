<?php
use bbn\Mvc;
use bbn\Str;
use bbn\Appui\Medias;
/** @var bbn\Mvc\Model $model */

if ($model->hasData(['ref', 'file'], true)) {
  $uploadPath = $model->userTmpPath() . $model->data['ref'] . '/' . $model->data['file'];
  if (is_file($uploadPath)) {
    return ['success' => unlink($uploadPath)];
  }
  else if (Str::isUid($model->data['id'])) {
    return ['success' => true];
    $idMedia = $model->data['id'];
    $medias = new Medias($model->db);
    if ($media = $medias->getMedia($idMedia, true)){
      die(var_dump($media));
      $content = Str::isJson($media['content']) ?
        json_decode($media['content'], true) :
        $media['content'];
      $path = $content['path'] . $idMedia . '/' . $media['name'];
      $root = Mvc::getDataPath('appui-note') . 'media/';
      if (is_file($root . $path)) {
        $medias->removeThumbs($root . $path); 
        return ['success' => unlink($root . $path)];
      }
    }
  }
}
return ['success' => false];
