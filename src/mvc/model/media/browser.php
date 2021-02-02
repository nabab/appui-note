<?php
/*
 * Describe what it does!
 *
 **/

/** @var $model \bbn\Mvc\Model*/
if ( !empty($model->data['limit']) && isset($model->data['start'])){
  $notes = new \bbn\Appui\Note($model->db);
  
  $path = $model->contentPath('appui-note').'media/';
	$img_extensions = ['jpeg', 'jpg', 'png', 'gif'];	
  $opt = $model->inc->options;
  $mds = $notes->getMediasNotes($model->data['start'], $model->data['limit']);
  
  $res = [];
  foreach( $mds as $i => $a ){
    $a['content'] = json_decode($a['content'], true);
    $full_path = $path.$a['content']['path'].$a['id'].'/'.$a['name'];
    $a['type'] = $opt->text($a['type']);

    $res[] = $a;
  }
  return [
    'medias' => $res
  ];
}