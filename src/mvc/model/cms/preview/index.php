<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/
if ($model->hasData(['url'])) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (bbn\Str::isUid($model->data['url'])) {
    $note = $cms->get($model->data['url']);
  }
  else {
    $note = $cms->getByUrl($model->data['url']);
  }

  if ($note) {
    return $note;
  }
}
