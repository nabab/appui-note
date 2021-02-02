<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/
$cms = new \bbn\Appui\Cms($model->db);
$res['success'] = false;

if ( !empty($model->data['id'])){
  $res['success'] = $cms->unpublish($model->data['id']);
}
return $res;