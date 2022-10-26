<?php
/**
 * What is my purpose?
 *
 **/
use bbn\Str;
use bbn\Shop\Product;
use bbn\Appui\Cms;
/** @var $model \bbn\Mvc\Model*/
$res['success'] = false;
if ($model->hasData('id', true)) {
  $prod = new Product($model->db);
	if ($product = $prod->get($model->data['id'])) {

    return [
      'success' => true,
      'data' => $product
    ];
  }
}

return $res;