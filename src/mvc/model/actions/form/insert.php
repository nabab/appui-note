<?php
if (($note = new \bbn\Appui\Note($model->db))
  && $model->hasData(['title', 'content'], true)
  && array_key_exists('id_type', $model->data)
  && array_key_exists('private', $model->data)
  && array_key_exists('locked', $model->data)
  && ($idNote = $note->insert(
    $model->data['title'],
    $model->data['content'],
    $model->data['id_type'],
    $model->data['private'],
    $model->data['locked'],
    null,
    null,
    $model->hasData('mime', true) ? $model->data['mime'] : '',
    $model->hasData('lang', true) ? $model->data['lang'] : ''
  ))
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
    $event = new \bbn\Appui\Event($model->db);
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