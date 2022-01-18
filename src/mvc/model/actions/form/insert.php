<?php
use bbn\Appui\Note;
use bbn\Appui\Event;
if (($note = new Note($model->db))
  && $model->hasData(['title', 'content'], true)
  && array_key_exists('id_type', $model->data)
  && array_key_exists('private', $model->data)
  && array_key_exists('locked', $model->data)
  && ($idNote = $note->insert($model->data))
) {
  $succ = true;
  if ($model->hasData('url', true)
    && !$model->db->insert('bbn_notes_url', [
      'id_note' => $idNote,
      'url' => $model->data['url']
    ])
  ) {
    $succ = false;
  }
  if ($model->hasData('start', true)) {
    $event = new Event($model->db);
    if (($typeEvent = $model->inc->options->fromCode('publication', 'event', 'appui'))
      && ($idEvent = $event->insert([
        'id_type' => $typeEvent,
        'start' => $model->data['start'],
        'end' => !empty($model->data['start']) ? $model->data['start'] : null
      ]))
      && !$model->db->insert('bbn_notes_events', [
        'id_note' => $idNote,
        'id_event' => $idEvent
      ])
    ) {
      $succ = false;
    }
  }
  return [
    'success' => $succ,
    'idNote' => $idNote
  ];
}
return ['success' => false];