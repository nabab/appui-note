<?php
$masks = new \bbn\Appui\Masks($model->db);
$cats = array_map(function($a){
  $a['content'] = '';
  return $a;
}, $masks->getAll());

return [
  'is_dev' => $model->inc->user->isDev(),
  'categories' => $cats,
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

  ])
];