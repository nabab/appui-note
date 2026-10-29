<?php
if ($model->hasData('url', true)) {
  $key = \bbn\Str::genpwd();
  $f = [
    'url' => urlencode($model->data['url']),
    'user' => $model->inc->user->getId(),
    'created' => date('Y-m-d H:i:s'),
    'expire' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
    'authkey' => $key
  ];
  $path = $model->userDataPath($model->inc->user->getId(), 'appui-note');
  if (\bbn\File\Dir::createPath($path)
    && file_put_contents($path.'fullpreview.json', json_encode($f, JSON_PRETTY_PRINT))
  ) {
    return [
      'success' => true,
      'previewUrl' => (defined('BBN_CMS_DOMAIN') ? BBN_CMS_DOMAIN : '') . $model->data['url'].'?user='.$model->inc->user->getId().'&authkey='.$key
    ];
  }
}