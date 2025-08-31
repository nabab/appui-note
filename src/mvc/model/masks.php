<?php

/** @var bbn\Mvc\Model $model */
$masks = new \bbn\Appui\Masks($model->db);
$all = $masks->getAll();
$cats = $model->inc->options->options('masks', 'appui');
return [
  'is_dev' => $model->inc->user->isDev(),
  'data' => $all,
  'cats' => $cats
];