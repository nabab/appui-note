<?php
/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 13/09/2018
 * Time: 10:40
 */

if ( isset($model->data['limit'], $model->data['start']) ){
  if ( !empty($model->data['filters']['conditions']) ){
    foreach ( $model->data['filters']['conditions'] as &$condition ){
      $table = ($condition['field'] === 'start') || ($condition['field'] === 'end') ? "bbn_events." : "versions.";
      $condition['field'] = $table.$condition['field'];     
    }
  }

  $grid = new \bbn\Appui\Grid($model->db, $model->data, [
    'table' => 'bbn_notes',
    'fields' => [
      'versions.id_note',
      'versions.version',
      'versions.title',
      'versions.content',
      'versions.id_user',
      'versions.creation',
      'bbn_events.start',
      'bbn_events.end'
    ],
    'join' => [[
      'table' => 'bbn_notes_events',
      'on' => [
        'conditions' => [[
          'field' =>  'bbn_notes_events.id_note',
          'operator' => '=',
          'exp' => 'bbn_notes.id'
        ]]
      ]
    ], [
      'table' => 'bbn_events',
      'on' => [
        'conditions' => [[
          'field' => 'bbn_events.id_type',
          'value' => $model->inc->options->fromCode('NEWS', 'evenements')
        ], [
          'field' => 'bbn_events.id',
          'exp' => 'bbn_notes_events.id_event'
        ]]
      ]
    ], [
      'table' => 'bbn_notes_versions',
      'alias'=> 'versions',
      'on' => [
        'conditions' => [[
          'field' => 'bbn_notes.id',
          'exp' => 'versions.id_note'
        ], [
          'field' => 'versions.latest',
          'value' => 1
        ]]
      ]
    ]],
    'where' => [
      'conditions' => [[
        'field' => 'bbn_notes.id_type',
        'value' => $model->inc->options->fromCode('news', 'types', 'note', 'appui')
      ], [
        'field' => 'bbn_notes.active',
        'value' => 1
      ]]
    ],
    'group_by' => 'bbn_notes.id',
    'order' => [[
      'field' => 'versions.version',
      'dir' => 'DESC'
    ], [
      'field' => 'versions.creation',
      'dir' => 'DESC'
    ]],
    'observer' => [
      'request' => [
        'table' => 'bbn_notes',
        'fields' => [
          'MAX(versions.creation)'
        ],
        'join' => [[
          'table' => 'bbn_notes_events',
          'on' => [
            'conditions' => [[
              'field' =>  'bbn_notes_events.id_note',
              'operator' => '=',
              'exp' => 'bbn_notes.id'
            ]]
          ]
        ], [
          'table' => 'bbn_events',
          'on' => [
            'conditions' => [[
              'field' => 'bbn_events.id_type',
              'value' => $model->inc->options->fromCode('NEWS', 'evenements')
            ], [
              'field' => 'bbn_events.id',
              'exp' => 'bbn_notes_events.id_event'
            ]]
          ]
        ], [
          'table' => 'bbn_notes_versions',
          'alias' => 'versions',
          'on' => [
            'conditions' => [[
              'field' => 'bbn_notes.id',
              'exp' => 'versions.id_note'
            ], [
              'field' => 'latest',
              'value' => 1
            ]]
          ]
        ]],
        'where' => [
          'conditions' => [[
            'field' => 'bbn_notes.id_type',
            'value' => $model->inc->options->fromCode('news', 'types', 'note', 'appui')
          ], [
            'field' => 'bbn_notes.active',
            'value' => 1
          ]]
        ],
        'group_by' => 'bbn_notes.id',
        'order' => [[
          'field' => 'versions.version',
          'dir' => 'DESC'
        ], [
          'field' => 'versions.creation',
          'dir' => 'DESC'
        ]],
      ],
      'name' => 'Widget news',
      'public' => false
    ]
  ]);

  if ( $grid->check() ){
    return $grid->getDatatable();
  }
}