<?php
$success = false;
if (!empty($ctrl->post['id'])) {
	$medias = new \bbn\Appui\Medias($ctrl->db);
  if (is_array($ctrl->post['id'])) {
    $success = true;
    foreach ($ctrl->post['id'] as $id) {
      if (!$medias->delete($id)) {
        $success = false;
      }
    }
  }
  else {
    $success = $medias->delete($ctrl->post['id']);
  }
}
$ctrl->obj->success = $success;