<?php

$res = [
  'success' => false
];
if ($model->hasData(['id', 'start'], true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (is_array($model->data['id'])) {
    $res['success'] = true;
    foreach ($model->data['id'] as $id) {
      if (!$cms->isPublished($id)
        && !$cms->publish($id, [
          'start' => $model->data['start'],
          'end' => $model->data['end']
        ])
      ) {
        $res['message'] = _("One or more posts could not be published");
      }
    }
  }
  else {
    $res['success'] = $cms->publish($model->data['id'], [
      'start' => $model->data['start'],
      'end' => $model->data['end']
    ]);
  }
}

return $res;
