<?php 

$cms = new \bbn\Appui\Cms($model->db);
return ['data'=> $cms->getTypes()];