<?php
/**
 * What is my purpose?
 *
 **/
use bbn\Str;
use bbn\Shop\Product;
use bbn\Appui\Cms;
/** @var bbn\Mvc\Model $model */
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