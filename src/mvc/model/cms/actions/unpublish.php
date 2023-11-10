<?php
$suc = [
  'success' => false
];
if ($model->hasData('id', true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (is_array($model->data['id'])) {
    $suc['success'] = true;
    foreach ($model->data['id'] as $id) {
      if ($cms->isPublished($id)
        && !$cms->unpublish($id)
      ) {
        $suc['message'] = _("One or more posts could not be unpublished");
      }
    }
  }
  else {
    $suc['success'] = $cms->unpublish($model->data['id']);
  }
}

return $res;
