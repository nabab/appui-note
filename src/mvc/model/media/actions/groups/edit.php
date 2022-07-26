<?php
if ($model->hasData(['id', 'file'], true)) {
  $medias = new bbn\Appui\Medias($model->db);
	$cms = new \bbn\Appui\Cms($model->db);

	$ok = 0;
	if(($name = $model->data['file'][0]['name']) && ($title = $model->data['file'][0]['title'])){
		$ok += count($medias->update($model->data['id'], $name, $title));
	}
	if($model->hasData(['idGroup']) && $model->data['file'][0]['link'] && \bbn\Str::isUrl($model->data['file'][0]['link'] )){

		$ok += $model->db->update('bbn_medias_groups_medias', [
			'link' => $model->data['file'][0]['link'] 
		],[
			'id_media' => $model->data['id'],
			'id_group' => $model->data['idGroup']

		]);		
	}

  return [
		'media' => $cms->getMedia($model->data['id'], true),
    'success' => !!$ok
  ];
}
return ['success' => false];