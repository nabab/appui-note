<?php
use bbn\X;

/** @var $model \bbn\Mvc\Model */

/** gets
{
    "id": "9b756a002ea811eca68b366237393031",
    "id_parent": null,
    "id_alias": null,
    "id_type": "2165e38a2ea511eca68b366237393031",
    "id_option": null,
    "excerpt": "Un nouveau test en français\n\n",
    "mime": "json/bbn-cms",
    "lang": "fr",
    "private": 0,
    "locked": 0,
    "pinned": 0,
    "creator": "752a9b0ef5ca11e89b35005056014c9f",
    "active": 1,
    "id_note": "9b756a002ea811eca68b366237393031",
    "version": 1,
    "title": "Un nouveau test en français",
    "id_user": "752a9b0ef5ca11e89b35005056014c9f",
    "creation": "2021-10-16 19:43:43",
    "url": "un-nouveau-test-en-francais",
    "start": null,
    "end": null,
    "items": [
        {
            "tag": "h1",
            "content": "rtytryrty",
            "color": "#000000",
            "align": "center",
            "decoration": "none",
            "italic": false,
            "hr": null,
            "type": "title",
        },
        {
            "type": "text",
            "text": "",
            "content": "rtyrtytryrtytry",
        },
        {
            "type": "text",
            "text": "",
            "content": "rtytrytrytryrty",
        },
    ],
}
*/

// The ID is the URL as it shoudn't be changed in this form

if ($model->hasData(['id', 'url', 'title'], true)) {
  $cms = new bbn\Appui\Cms($model->db);
  $content = empty($model->data['items']) ? '[]' : json_encode($model->data['items']);
  return [
    'success' => $cms->set([
      'url' => $model->data['url'],
      'title' => $model->data['title'],
      'excerpt' => $model->data['excerpt'] ?? '',
      'id_note' => $model->data['id_note'],
      'content' => $content,
      'start' => $model->data['start'] ?? null,
      'end' => $model->data['end'] ?? null,
      'tags' => $model->data['tags'],
      'id_type' => $model->data['id_type'],
      'id_media' => $model->data['id_media']
    ])
  ];
}
