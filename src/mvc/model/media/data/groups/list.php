<?php
$grid = new \bbn\Appui\Grid($model->db, $model->data, [
  'table' => 'bbn_medias_groups',
  'fields' => []
]);
return $grid->getDataTable();