<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

use bbn\X;

$res['success'] = false;


/*if ($model->data['id']) {
  $model->inc->pref->updateBit($model->data['id'], [
    'count' => $model->data['count'] + 1 ?? 0,
  ], true);
  $res['success'] = true;
}*/

//X::ddump($res, $model->data['count'], $model->data['id']);

return $res;