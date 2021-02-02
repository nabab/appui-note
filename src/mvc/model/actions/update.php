<?php
/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 20/07/17
 * Time: 17.09
 *
 * @var $model \bbn\Mvc\Model
 */
$res = [
  'success' => false
];
$notes = new \bbn\Appui\Note($model->db);
if ( !empty($model->data['id_note']) && isset($model->data['content']) ){
  $ok = $notes->update($model->data['id_note'], $model->data['title'] ?? '', $model->data['content']);
  if (
      !empty($model->data['type']) &&
      isset($model->data['start']) &&
      ($type_news = $model->inc->options->fromCode('news', 'types', 'note', 'appui')) &&
      ($model->data['type'] === $type_news) &&
      ($type_event = $model->inc->options->fromCode('NEWS', 'evenements')) &&
    	($id_event = $model->db->selectOne('bbn_notes_events', 'id_event', ['id_note' => $model->data['id_note']])) &&
      $model->db->update('bbn_events', [
        'start' => $model->data['start'],
        'end' => !empty($model->data['end']) && (strtotime($model->data['start']) < strtotime($model->data['end'])) ? $model->data['end'] : NULL
      ], ['id' => $id_event])
    ){
      $ok2 = true;
    }
    $res['success'] = !empty($ok) || !empty($ok2);
}
return $res;