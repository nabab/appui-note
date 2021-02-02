<?php
$success = false;
if ( !empty($ctrl->post['id']) ){
	$medias = new \bbn\Appui\Medias($ctrl->db);
  $success = $medias->delete($ctrl->post['id']);
}
$ctrl->obj->success = $success;