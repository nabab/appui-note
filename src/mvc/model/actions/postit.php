<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
use bbn\Appui\Note;
/** @var $model \bbn\Mvc\Model*/

$res = ['success' => false];
if ($model->hasData('action', true)) {
  $note = new Note($model->db);
  switch ($model->data['action']) {
    case 'save':
      if ($model->hasData('data', true) &&
          is_array($model->data['data']) &&
          X::hasProps($model->data['data'], ['title', 'text', 'fcolor', 'bcolor']) &&
          $note->savePostIt($model->data['data'])
      ) {
        return [
          'success' => true,
          'data'    => $note->getPostIt($model->data['data']['id'])
        ];
      }
      break;
  }
}

return $res;
