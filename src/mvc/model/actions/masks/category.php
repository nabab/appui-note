<?php
use bbn\Appui\Masks;

$suc = false;
if ($model->inc->user->isDev()
  && $model->hasData(['text', 'code'], true)
  && $model->hasData(['id', 'preview', 'preview_model', 'preview_inputs', 'fields'])
  && ($idOpt = $model->inc->options->fromCode('options', 'masks', 'appui'))
) {
  $masks = new Masks($model->db);
  $o = [
    'id_parent' => $idOpt,
    'text' => $model->data['text'],
    'code' => $model->data['code'],
    'preview' => $model->data['preview'],
    'preview_model' => $model->data['preview'] === 'model' ? $model->data['preview_model'] : '',
    'preview_inputs' => !empty($model->data['preview_inputs']) ? $model->data['preview_inputs'] : [],
    'fields' => !empty($model->data['fields']) ? $model->data['fields'] : []
  ];
  $suc = $model->hasData('id', true) ?
    !!$masks->updateCategory($model->data['id'], $o) :
    !!$masks->insertCategory($o);
}

return ['success' => $suc];