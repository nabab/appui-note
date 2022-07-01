<?php
if ($model->hasData('file', true) && $model->hasData('all')) {
  if (!$model->hasData('all', true)) {
    return ['success' => \bbn\File\Dir::delete(BBN_PUBLIC . $model->data['file'])];
  }
  return ['success' => \bbn\File\Dir::delete(dirname(BBN_PUBLIC . $model->data['file']))] ;
}
return ['success' => false];