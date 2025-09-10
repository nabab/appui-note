<?php
use bbn\Appui\Masks;

$masks = new Masks($model->db);
$models = $model->getModel('./data/masks/models');
return [
  'is_dev' => $model->inc->user->isDev(),
  'list' => array_map(function($a){
    $a['content'] = '';
    return $a;
  }, $masks->getAll()),
  'emptyCategories' => $model->db->rselectAll([
    'tables' => 'bbn_options',
      'fields' => [
        'bbn_options.id',
        'bbn_options.code',
        'bbn_options.text'
      ],
      'join' => [[
        'table' => 'bbn_notes_masks',
        'type' => 'left',
        'on' => [
          'conditions' => [[
            'field' => 'bbn_options.id',
            'exp' => 'bbn_notes_masks.id_type'
          ]]
        ]
      ]],
      'where' => [
        'conditions' => [[
          'field' => 'bbn_notes_masks.id_type',
          'operator' => 'isnull'
        ], [
          'field' => 'bbn_notes_masks.id_note',
          'operator' => 'isnull'
        ], [
          'field' => 'bbn_options.id_parent',
          'value' => $model->inc->options->fromCode('options', 'masks', 'appui')
        ]]
      ]
  ]),
  'categories' => $model->inc->options->fullOptions('options', 'masks', 'appui'),
  'models' => !empty($models['data']) ? $models['data'] : []
];