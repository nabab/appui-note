<?php
if ($model->hasData(['id', 'ref', 'file'], true)) {

  $id = $model->data['id'];
  if (is_array($model->data['file'])) {
    $model->data = \bbn\X::mergeArrays($model->data, $model->data['file'][0]);
  }
  $medias = new \bbn\Appui\Medias($model->db);
  if ($model->hasData('tags')) {
    $cms = new \bbn\Appui\Cms($model->db);
  }
  else {
    $cms =& $medias;
  }

  $oldMedia = $cms->getMedia($id, true);
  if (!empty($model->data['name'])) {
    $res = [
      'success' => true,
      'media' => false
    ];
    $tmpPath = $model->userTmpPath() . $model->data['ref'] . '/';
    if (($oldMedia['name'] !== $model->data['name'])
      && is_file($tmpPath . $model->data['name'])
    ) {
      if (!empty($oldMedia['url'])) {
        $model->getModel($model->pluginUrl('appui-note'), '/media/actions/clear_chache', ['file' => $oldMedia['url'], 'all' => true]);
      }
      $res['media'] = $medias->replaceContent($id, $tmpPath . $model->data['name']);
      if (empty($res['media'])) {
        throw new Error(_('Error while replacing the media'));
      }

    }
    if ($oldMedia['title'] !== $model->data['title']) {
      if (empty($model->data['title'])) {
        $ext = \bbn\Str::fileExt($model->data['name']);
        $model->data['title'] = trim(str_replace(['-', '_', '+'], ' ', \bbn\X::basename($model->data['name'], ".$ext")));
      }
      if (!$medias->setTitle($id, $model->data['title'])) {
        throw new Error(_('Error while replacing the media title'));
      }
    }
    if ($oldMedia['description'] !== $model->data['description']) {
      if (!$medias->setDescription($id, $model->data['description'])) {
        throw new Error(_('Error while replacing the media description'));
      }
    }

    if ($model->hasData('tags')) {
      if ($oldMedia['tags'] !== $model->data['tags']) {
        $medias->setTags($id, $model->data['tags']);
      }

    }

    $res['media'] = $cms->getMedia($id, true);

    return $res;
  }
}
return ['success' => false];
