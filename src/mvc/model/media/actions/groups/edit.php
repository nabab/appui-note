<?php


if ($model->hasData(['id', 'file'], true)) {
  $medias = new bbn\Appui\Medias($model->db);
	$ok = 0;
	
	if(($name = $model->data['file'][0]['name']) && ($title = $model->data['file'][0]['title'])){
		$ok += count($medias->update($model->data['id'], $name, $title));
	}
	if(!empty($model->data['linkUrl'])){
		
		//here update the url of the media!
	}

  return [
    'success' => !!$ok
  ];
}
return ['success' => false];