<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/
use bbn\Appui\Grid;
if ($model->hasData('id') && $model->inc->options->exists($model->data['id'])) {
  $grid = new Grid($model->db, $model->data, [
    'tables' => ['bbn_notes'],
    'fields' => [
      'title',
      'id_note',
      'id_type'
    ],
    'join' => [
      [
        'table' => 'bbn_notes_versions',
        'on' => [
          [
            'field' => 'bbn_notes.id',
            'exp' => 'id_note'
          ], [
            'field' => 'latest',
            'value' => 1
          ]
        ]
      ]
    ],
    'where' => [
      'id_type' => $model->data['id']
    ],
    'group_by' => ['id_note'],
    'order' => [
      'creation' => 'DESC'
    ]
  ]);
  return $grid->getDatatable();
}
