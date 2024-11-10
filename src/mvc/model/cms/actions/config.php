<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
/** @var bbn\Mvc\Model $model */

$res = [
  'success' => false,
];
if ($model->hasData(['config', 'name'], true)) {
  $idParent = $model->inc->options->fromCode('pblocks', 'note', 'appui');
  $idBlock = $model->inc->options->fromCode($model->data['config']['type'] ?? null, 'blocks', 'note', 'appui');
  if ($idParent && $idBlock) {
    $cfg = [];
    $e = [[], "", null];
    unset($model->data['config']['type']);
    foreach($model->data['config'] as $prop => $value) {
      if (!in_array($value, $e, true)) {
        $cfg[$prop] = $value;
      }
    }
    $res['success'] = $model->inc->options->add([
      'id_parent' => $idParent,
      'id_alias' => $idBlock,
      'text' => $model->data['name'],
      'configuration' => $cfg,
    ]);
  }
}
return $res;