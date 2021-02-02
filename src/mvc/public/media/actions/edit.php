<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\Mvc\Controller 
 *
 */

$success = false;
$img_extensions = ['jpeg', 'jpg', 'png', 'gif'];	
if (!empty($ctrl->post['media']['id']) && !empty($ctrl->post['media']) && ($title = $ctrl->post['media']['title'] ) ){
  $media = [];
  $ctrl->obj->success = true;
  $medias = new \bbn\Appui\Medias($ctrl->db);
  $fs = new \bbn\File\System();
  $root = bbn\Mvc::getDataPath('appui-note').'media/';
  $path = bbn\X::makeStoragePath($root, '', 0, $fs);
  $full_path = $path.$ctrl->post['media']['id'].'/'.$ctrl->post['media']['name'];
  
  $new_name = $ctrl->post['media']['name'];
  $old_name = $ctrl->post['media']['content']['name'];
  if ( empty($ctrl->post['removedFile']) ) {
    $media = $medias->update($ctrl->post['media']['id'], $new_name, $title);
    $tmp = json_decode($media['content'], true);
    $ext = $tmp['extension'];
    if ( array_search($ext, $img_extensions) ){
      $imageData = base64_encode(file_get_contents($full_path));
      // Format the image SRC:  data:{mime};base64,{data};
      $src = 'data: '.mime_content_type($full_path).';base64,'.$imageData;
      $media['src'] = $src;
    }
  }
  else{
    $media = $medias->updateContent($ctrl->post['media']['id'], $ctrl->post['ref'],$old_name, $ctrl->post['media']['name'], $title);
  }
  if(!empty($media)){
    $notes= new \bbn\Appui\Note($ctrl->db);
    $media['notes'] = $notes->getMediaNotes($media['id']);
		$ctrl->obj->media = $media;      
    $ctrl->obj->success = true;
  }
}