<?php
use bbn\Appui\Masks;
use bbn\Str;

$masks = new Masks($model->db);
return [
  'success' => !empty($model->data['id_note'])
    && Str::isUid($model->data['id_note'])
    && $masks->setDefault($model->data['id_note'])
];
