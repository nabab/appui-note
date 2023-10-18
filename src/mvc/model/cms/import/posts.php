<?php
/** @var $this \bbn\mvc\model*/
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 6.0)');
use bbn\X;
use bbn\Appui\Note;
use bbn\File\System;

//$articles = $model->db->count('articles');
$opt =& $model->inc->options;
$notes = new Note($model->db);

if ($model->data['action'] == 'undo') {
  $model->db->delete('bbn_notes_tags', []);
  $ids = $model->db->getColumnValues('bbn_notes', 'id', ['mime' => 'json/bbn-cms']);
  foreach ($ids as $id_note) {
    $num += (int)$notes->delete($id_note);
  }

  return ['message' => "Process undo successfully, $num notes deleted."];
}
else {
  //Inserts the option tags
  //Id de appui-note
  $parent = $opt->fromCode('note', 'appui');

  $tags = $model->db->rselectAll('categories');
  foreach($tags as $t ){
    $model->db->insertIgnore('bbn_tags', [
      'tag' => $t['title'],
      'lang' => 'en',
      'description' => '',
      'url' => $t['name']
    ]);
  }

  $periods = [[
    'text' => 'Limited edition',
  ],[
    'text' => 'Edition 2021'
  ],[
    'text' => 'Contemporary authors',
    'description' => 'This section offers a selection of contemporary authors who have depicted China from the early 1980s onwards.'
  ],[
    'text' => 'Historical authors',
    'description' => 'The following section introduces authors who have captured the country between the establishment of the People\'s Republic of China (1949) and the late 1970s.',
  ],[
    'text' => '1840-1949',
    'description' => 'The authors below were active between the arrival of photography in the 1840s and 1949.'
  ]];

  foreach($periods as $p){
    $code = str_replace(' ','-', strtolower($p['text']));
    $model->db->insertIgnore('bbn_tags', [
      'tag' => $p['text'],
      'lang' => 'en',
      'description' => $p['description'],
      'url' => $code
    ]);
  }

  $fs = new System();

  //INSERT THE NOTES, NOTES_VERSIONS, URL AND EVENTS FOR POSTS AND PAGES
  //select all articles from db
  $id_user = $model->db->selectOne('bbn_users', 'id', ['email'=> 'marinecabos@yahoo.fr']);
  $type_event = $opt->fromCode('publication', 'types', 'event', 'appui');
  $type_note = [
    'page' => $opt->fromCode('pages', 'types', 'note', 'appui'),
    'post' => $opt->fromCode('post', 'types', 'note', 'appui')
  ];

  $q = $model->db->query("SELECT * FROM articles");
  $num = 0;
  while ($article = $q->getRow()) {

    //if the item is type post or page (always without parent), it creates the note
    if (($article['type'] === 'post') || ($article['type'] === 'page'))
    {
      if ($model->db->count('bbn_notes_url', [
        'url' => $article['url']
      ])) {
        continue;
      }

      //the type of each item
      $type = null;
      //if the note doesn't exist it inserts the note
      $id_note = null;

      if (($article['parent'] === null) && !$model->db->count([
          'table'=> 'bbn_notes',
          'where'   => [
            'conditions' => [[
              'field' => 'bbn_notes_versions.title',
              'value' => $article['title']
            ], [
              'field' => 'bbn_notes_versions.content',
              'value' => $article['content']
            ]]
          ],
          'join' => [[
            'table' => 'bbn_notes_versions',
            'on' => [
              'logic' => 'AND',
              'conditions' => [[
                'field' => 'bbn_notes_versions.id_note',
                'operator' => '=',
                'exp' => 'bbn_notes.id'
              ]]
            ]
          ]]
        ])
      ) {
        $id_note = $notes->insert([
          'title' => $article['title'],
          'content' => $article['bbn_cfg'],
          'type' => $type_note[$article['type']],
          'id_option' => null,
          'mime' => 'json/bbn-cms',
          'lang' => 'en'
        ]);
      }
      //updates the user in bbn_notes and bbn_notes_∞version to have the correct date and user
      if (!empty($id_note)){
        $num++;
        $model->db->update('bbn_notes', ['creator'=> $id_user], ['id' => $id_note]);
        $model->db->update('bbn_notes_versions', [
          'id_user' => $id_user,
          'creation' => $article['pubDate']
        ], ['id_note' => $id_note]);
        if ( $article['status'] === 'publish' ){
          //the event is inserted in bbn_events
          $model->db->insert('bbn_events', [
            'id_type' => $type_event,
            'start' => $article['pubDate'],
            'end' => NULL,
            'name' => $article['title'] ?? ''
          ]);

          $id_event = $model->db->lastId();


          //the event is linked to the note in bbn_notes_events
          $model->db->insert('bbn_notes_events', [
            'id_note' => $id_note,
            'id_event' => $id_event
          ]);
        }
        //if the url has not yet been inserted it inserts the url in bbn_notes_url
        if (!empty($article['url'])) {
          $model->db->insert('bbn_notes_url', [
            'id_note' => $id_note,
            'url' => $article['url']
          ]);
          $file = BBN_DATA_PATH.'photographers/'.urlencode(X::basename($article['url'])).'.json';
          //takes the images for each photographer from the file json
          $num_medias = 0;
          if (is_file($file)){

            //the urls in content need to be urldecode at the moment of taking the data, I can't store it decoded in the json_array
            $content = file_get_contents($file);
            $medias = json_decode($content, true);
            $num_medias = count($medias);
            foreach($medias as $m ){
              if ($id_media = $model->db->selectOne('bbn_medias_url', 'id_media', ['url' => urldecode($m)])) {
                $notes->addMediaToNote($id_media, $id_note, 1);
              }
            }
          }
          if ($id_ph = $model->db->selectOne('photographers', 'id', ['url' => urldecode($article['url'])])) {
            $model->db->update('photographers', [
              'id_note' => $id_note,
              'num_media' => $num_medias,
            ], ['id' => $id_ph]);
          }
        }

        if ($article_tags = json_decode($article['tags'], true)) {
          foreach($article_tags as $i => $tag ){
            $notes->addTag($id_note, $tag['value'], 'en');
          }
        }
      }
    }
  }

  //INSERTS ALL ATTACHMENTS IN MEDIA
  return ['message' => "Process launch successfully, $num notes inserted"];
}