<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/
$cms = new \bbn\Appui\Cms($model->db);
$res['success'] = false;
if (!empty($model->data['id_note'])){
  $res['success'] = $cms->publish(
    $model->data['id_note'], 
    [
      'start' => $model->data['start'],
      'end' => $model->data['end']
    ]);
}
return $res;