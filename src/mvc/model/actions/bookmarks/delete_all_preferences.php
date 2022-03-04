<?php
/**
   * What is my purpose?
   *
   **/

/** @var $model \bbn\Mvc\Model*/

use bbn\X;

$res['success'] = false;

//$model->inc->pref->deleteBits($model->data['allId']);

foreach($model->data['allId'] as $bit) {
  if $bit['value'] {
	  $model->inc->pref->deleteBit($bit['value']);
  }
  $res['success'] = true;
}

return $res;