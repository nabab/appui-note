<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/
if ($model->hasData(['url'])) {
  $cms = new \bbn\Appui\Cms($model->db);
  if ( $note = $cms->get($model->data['url']) ){
    $note['url'] = $model->data['url'];
    
    return $note;
  }
}