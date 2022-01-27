<?php
if ($model->hasData(['id', 'ref', 'file'], true)) {

  $id = $model->data['id'];
  $medias = new \bbn\Appui\Medias($model->db);
  $oldMedia = $medias->getMedia($id, true);
  $file = $model->data['file'][0];
  if (!empty($file['name'])) {
    $res = [
      'success' => true,
      'media' => false
    ];
    $tmpPath = $model->userTmpPath() . $model->data['ref'] . '/';
    if (($oldMedia['name'] !== $file['name'])
      && is_file($tmpPath . $file['name'])
    ) {
      $res['media'] = $medias->replaceContent($id, $tmpPath . $file['name']);
      if (empty($res['media'])) {
        throw new Error(_('Error while replacing the media'));
      }
    }
    if ($oldMedia['title'] !== $file['title']) {
      if (empty($file['title'])) {
        $ext = \bbn\Str::fileExt($file['name']);
        $file['title'] = trim(str_replace(['-', '_', '+'], ' ', \bbn\X::basename($file['name'], ".$ext")));
      }
      if (!$medias->setTitle($id, $file['title'])) {
        throw new Error(_('Error while replacing the media title'));
      }
    }
    if ($oldMedia['description'] !== $file['description']) {
      if (!$medias->setDescription($id, $file['description'])) {
        throw new Error(_('Error while replacing the media description'));
      }
    }
    if (empty($res['media'])) {
      $res['media'] = $medias->getMedia($id, true);
    }
    return $res;
  }
}
return ['success' => false];
