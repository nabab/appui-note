<?php
/** @var bbn\Mvc\Model $model */

use bbn\X;
use bbn\Appui\Note;
use bbn\Appui\Event;

$res = ['success' => false];

if ( !empty($model->data['title']) || !empty($model->data['content']) ){
  $note = new Note($model->db);
  $event = new Event($model->db);
  if ( $id_note = $note->insert($model->data)) {
    $ok = true;
    if ( 
      !empty($model->data['type']) &&
      isset($model->data['start']) &&
      ($type_news = $model->inc->options->fromCode('news', 'types', 'note', 'appui')) &&
      ($model->data['id_type'] === $type_news) &&
      ($type_event = $model->inc->options->fromCode('NEWS', 'evenements')) &&
      $model->db->insert('bbn_events', [
        'id_type' => $type_event,
        'start' => $model->data['start'],
        'end' => !empty($model->data['end']) && (strtotime($model->data['start']) < strtotime($model->data['end'])) ? $model->data['end'] : null
      ]) &&
      ($id_event = $model->db->lastId()) &&
      $model->db->insert('bbn_notes_events', [
        'id_note' => $id_note,
        'id_event' => $id_event
      ])
    ) {
      $res['event'] = $event->get($id_event);
      $ok2 = true;
    }

    $res['data'] = $note->get($id_note);
    $res['success'] = isset($ok2) ? ($ok === $ok2) : $ok;
  }
}

return $res;
