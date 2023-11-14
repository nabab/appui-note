<?php
$res = [
  'success' => false
];
if ($model->hasData('id', true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (is_array($model->data['id'])) {
    $res['success'] = true;
    foreach ($model->data['id'] as $id) {
      if (!$cms->delete($id)) {
        $res['message'] = _("One or more posts could not be deleted");
      }
    }
  }
  else {
    $res['success'] = $cms->delete($model->data['id']);
  }
}

return $res;
