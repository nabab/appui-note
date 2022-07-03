<?php 

$cms = new \bbn\Appui\Cms($model->db);
$data = $cms->getTypes();
$data[] = ['text' => 'News', 'value'=> 'news'];
return ['data'=> $data];