<?php
die(var_dump('test'));
if($todo = $ctrl->post){
  $medias = new \bbn\Appui\Medias($ctrl->db);
  $fs = new \bbn\File\System();
  foreach($todo as $t){
    $media = $medias->getMediaPath($t['id']);
    if(is_file($media)){
      $ctrl->obj->file[] = $media;
    
      
    }
    else{
      header('Location: /admin/'.$ctrl->pluginUrl('appui-core').'/error/download');
      exit();
    }
    
  }
  
}