<?php
if ($model->hasData(['file', 'ref'], true)) {
  $files = $model->data['file'];
	$medias = new \bbn\Appui\Medias($model->db);
  $tmpPath = $model->userTmpPath() . $model->data['ref'] . '/';
  $res = [];
  foreach($files as $f){
    $filePath = $tmpPath . $f['name'];
    $title = !empty($f['title']) && ($f['title'] !== $f['name']) ? $f['title'] : '';
    if (is_file($filePath)) {
      if ($id = $medias->insert($filePath, null , $title, 'file', false, !empty($f['description']) ? $f['description'] : null)){
        $media = $medias->getMedia($id, true);
        if (empty($media['private'])
          && empty($media['url'])
        ) {
          $medias->addUrl($id, 'img/' . $id . '/' . $media['name']);
          $media = $medias->getMedia($id, true);
        }
        if (!empty($media['content']) && \bbn\Str::isJson($media['content'])) {
          $media['content'] = json_decode($media['content']);
        }
        $res[] = $media;
      }
    }
  }
  if (!empty($res)) {
    return [
      'success' => true,
      'media' => count($res) > 1 ? $res : $res[0]
    ];
  }
}
return ['success' => false];
