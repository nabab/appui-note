<?php
$suc = false;
if ($model->hasData('id', true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (is_array($model->data['id'])) {
    $suc = true;
    foreach ($model->data['id'] as $id) {
      if ($cms->isPublished($id)
        && !$cms->unpublish($id)
      ) {
        $suc = false;
      }
    }
  }
  else {
    $suc = $cms->unpublish($model->data['id']);
  }
}

return ['success' => $suc];