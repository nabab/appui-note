<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\Mvc\Controller 
 *
 */
$success = false;
if ( $id_media = $ctrl->arguments[0] ){
  $medias = new \bbn\Appui\Medias($ctrl->db);
  $fs = new \bbn\File\System();
  if ( $media = $medias->getMedia($id_media, true) ){
    $content = json_decode($media['content'],true);
    $path = $content['path'].$id_media.'/'.$media['name'];
    $root = \bbn\Mvc::getDataPath('appui-note').'media/';
 	
    if ( $fs->exists($root.$path) ){
      $ctrl->obj->removed = true;
      if ( !empty($medias->getThumbsPath($root.$path)) ){
        $medias->removeThumbs($root.$path);
      }
      $success = unlink($root.$path);
      $ctrl->obj->success = $success;		
    }
  }
	  
}