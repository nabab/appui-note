<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

use bbn\X;

$res['success'] = false;


if ($model->data['id']) {
  $model->inc->pref->updateBit($model->data['id'], [
    'clicked' => ($model->data['clicked'] ?? 0) + 1,
  ], true);
  $res['success'] = true;
}

//X::ddump($res, $model->data['count'], $model->data['id']);

return $res;