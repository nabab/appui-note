<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/
$model->db->change('apst_web');
$res = [
  'types' => $model->db->getColumnValues('wp_posts', 'post_type'),
  'statuses' => $model->db->getColumnValues('wp_posts', 'post_status')
];
$model->db->change('apst_app');
return $res;