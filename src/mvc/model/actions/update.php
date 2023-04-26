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
if ($model->hasData('id_note', true)) {
  if ($model->hasData('content')) {
    $ok = $notes->update(
      $model->data['id_note'],
      $model->data['title'] ?? '',
      $model->data['content'],
      $model->hasData('private') ? $model->data['private'] : 0,
      $model->hasData('locked') ? $model->data['locked'] : 0,
      $model->hasData('excerpt') ? $model->data['excerpt'] : '',
      $model->hasData('pinned') ? $model->data['pinned'] : 0,
      $model->hasData('important') ? $model->data['important'] : 0
    );
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
  elseif ($model->hasData('important')) {
    $res['success'] = empty($model->data['important']) ? $notes->unsetImportant($model->data['id_note']) : $notes->setImportant($model->data['id_note']);
  }
}
return $res;