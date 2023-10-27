<?php

$suc = false;
if ($model->hasData(['id', 'start'], true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (is_array($model->data['id'])) {
    $suc = true;
    foreach ($model->data['id'] as $id) {
      if (!$cms->isPublished($id)
        && !$cms->publish($id, [
          'start' => $model->data['start'],
          'end' => $model->data['end']
        ])
      ) {
        $suc = false;
      }
    }
  }
  else {
    $suc = $cms->publish($model->data['id'], [
      'start' => $model->data['start'],
      'end' => $model->data['end']
    ]);
  }
}

return ['success' => $suc];