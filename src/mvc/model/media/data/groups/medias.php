<?php
if ($model->hasData(['data', 'limit'], true)
  && $model->hasData('start')
  && !empty($model->data['data']['idGroup'])
) {
  $medias = new \bbn\Appui\Medias($model->db);
  return $medias->browseByGroup($model->data['data']['idGroup'], $model->data);
}
return [
  'success' => false
];