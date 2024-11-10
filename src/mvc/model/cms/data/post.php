<?php
/**
 * What is my purpose?
 *
 **/

use bbn\Appui\Cms;

/** @var bbn\Mvc\Model $model */
$res['success'] = false;

if ($model->hasData('url', true)) {
  $note = new Cms($model->db);
  if ($data = $note->getByUrl($model->data['url'], true)) {
    return [
      'success' => true,
      'data' => $data
    ];
  }
}
return $res;
