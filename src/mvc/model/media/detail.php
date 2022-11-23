<?php
if ($model->hasData('id', true)) {
  $cms = new \bbn\Appui\Medias($model->db);
  $media = $cms->getMedia($model->data['id'], true);
  if (!empty($media['url']) && is_dir(BBN_PUBLIC . dirname($media['url']))) {
    $media['cacheFiles'] = array_map(function($f){
      return [
        'file' => str_replace(BBN_PUBLIC, '', $f),
        'name' => basename($f),
        'modified' => filemtime($f)
      ];
    }, \bbn\File\Dir::getFiles(BBN_PUBLIC . dirname($media['url'])));
  }
  $media["thumbs"] = array_map(function($a) use ($model, $media) {
    return BBN_URL . $model->pluginUrl("appui-note") . '/media/image/' . $media['id'] . '/' . basename($a);
  }, $cms->getThumbsPath($media));
  return [
    'title' => $media['title'],
    'media' => $media
  ];
}
return [];