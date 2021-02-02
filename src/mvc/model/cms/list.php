<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/

$db = new \bbn\Db();
$opt = new \bbn\Appui\Option($db);
$notes = new \bbn\Appui\Note($db);
$cms = new \bbn\Appui\Cms($model->db);

$all = [
  'data' => [],
  'total' => 0,
];

$notes = $cms->getAll();
if(isset($model->data['start']) && isset($model->data['limit'])){
	$all['data'] = array_slice($notes, $model->data['start'], $model->data['limit']);
}
$all['total'] = count($notes);

//$content_path = \bbn\Mvc::getContentPath();
return $all;