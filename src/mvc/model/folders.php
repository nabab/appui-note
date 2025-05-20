<?php

use bbn\X;
use bbn\Str;
use bbn\User\Folder;
/** @var bbn\Mvc\Model $model */

if ($model->hasData('action')) {
  $res = ['success' => false];
  $folder = new Folder($model->inc->pref);
  
  switch ($model->data['action']) {
    case 'data':
      $res['success'] = true;
      $id_parent = $model->hasData('data', true) && $model->data['data']['id'] ? $model->data['data']['id'] : null;
      $res['data'] = $folder->list($id_parent);
      break;
    case 'create':
      if ($model->hasData(['text'], true)) {
        try {
          $res['data'] = $folder->create($model->data['text'], $model->data['id_parent'] ?? null);
          $res['success'] = true;
        }
        catch (Exception $e) {
          $res['error'] = $e->getMessage();
        }
      }
      else {
        $res['error'] = X::_("No text has been entered");
      }
      break;
    case 'move':
      if ($model->hasData(['id', 'parent'], true)) {
        try {
          if ($folder->move($model->data['id'], $model->data['parent'])) {
            $res['success'] = true;
          }
        }
        catch (Exception $e) {
          $res['error'] = $e->getMessage();
        }
      }
      break;
  }

  return $res;
}
