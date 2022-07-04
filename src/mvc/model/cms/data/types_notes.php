<?php 

$cms = new \bbn\Appui\Cms($model->db);

if($model->hasData(['id_root_alias'])){
  $data = $model->inc->options->fullOptionsCfg($model->data['id_root_alias']);
}
else{
  $data = $cms->getTypes();
  $data[] = ['text' => 'News', 'value'=> 'news'];
}
return [
  'data'=> $data
];