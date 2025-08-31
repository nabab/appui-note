<?php
/*
 * Describe what it does!
 *
 * @var bbn\Mvc\Controller $ctrl 
 *
 */
$success = false;
if (!empty($ctrl->post['id']) && !empty($ctrl->post['title']) ){
  $success = $ctrl->db->update('bbn_medias', ['title' => $ctrl->post['title']], [
    'id' => $ctrl->post['id']
  ]);
}
$ctrl->obj->success = $success;