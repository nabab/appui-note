<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

use bbn\X;
use bbn\Appui\Grid;

if ($model->hasData('id')) {
  $cfg = [
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
            'exp' => 'bbn_notes_versions.id_note'
          ], [
            'field' => 'latest',
            'value' => 1
          ]
        ]
      ]
    ],
    'group_by' => ['bbn_notes.id']
  ];
  $ok = false;
  if (in_array($model->data['id'], ['pub', 'unpub'])) {
    $cfg['join'][] = [
      'table' => 'bbn_notes_events',
      'on' => [
        [
          'field' => 'bbn_notes.id',
          'exp' => 'bbn_notes_events.id_note'
        ]
      ]
    ];
    $cfg['join'][] = [
      'table' => 'bbn_events',
      'on' => [
        [
          'field' => 'bbn_events.id',
          'exp' => 'bbn_notes_events.id_event'
        ]
      ]
    ];
    if ($model->data['id'] === 'pub') {
      $cfg['where'] = [
        [
          'field' => 'start',
          'operator' => '>',
          'value' => date('Y-m-d H:i:s', strtotime("1 month ago"))
        ]
      ];
      $cfg['order'] = [
        'start' => 'ASC'
      ];
    }
    else {
      $cfg['where'] = [
        [
          'field' => 'end',
          'operator' => '>',
          'value' => date('Y-m-d H:i:s', strtotime("1 month ago"))
        ],
        [
          'field' => 'start',
          'operator' => 'isnotnull'
        ]
      ];
      $cfg['order'] = [
        'end' => 'ASC'
      ];
    }
    array_push($cfg['fields'], 'start', 'end');
    $ok = true;
  }
  elseif ($option = $model->inc->options->option($model->data['id'])) {
    $cfg['where'] = [
      'id_type' => $model->data['id']
    ];
    $cfg['order'] = [
      'creation' => 'DESC'
    ];
    $ok = true;
  }

  if ($ok) {
    $grid = new Grid($model->db, $model->data, $cfg);
    $data = $grid->getDatatable();
    if ($option) {
      array_walk($data['data'], function (&$a) use (&$option){
        $a['code'] = $option['code'];
      });
    }
    return $data;
  }

}
