<?php
/*
 * Describe what it does!
 *
 * @var bbn\Mvc\Controller $ctrl 
 *
 */
$success = false;
if ( ($id_note = $ctrl->post['id_note']) &&
    ($id_media = $ctrl->post['id_media']) &&
    isset($ctrl->post['version'])
   ){
  $notes = new \bbn\Appui\Note($ctrl->db);
  $success = $notes->addMediaToNote($id_media, $id_note, $ctrl->post['version']);
}
$ctrl->obj->success = $success;