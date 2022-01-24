<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

use bbn\X;

$res['success'] = false;


if ($model->data['id']) {
  $res['id'] = $model->data['id'];
	$res['count'] = $model->data['count'] + 1;
  $res['success'] = true;
}

//X::ddump($res, $model->data['count'], $model->data['id']);

return $res;