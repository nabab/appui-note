<?php
$models = $model->getCustomModelGroup('masks', 'appui-note');
array_walk($models, function(&$m, $p) {
  $m['id'] = $p;
});
return [
  'success' => true,
  'data' => array_values($models)
];
