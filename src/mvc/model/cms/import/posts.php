<?php
/** @var $this \bbn\mvc\model*/
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 6.0)');
use bbn\X;
use bbn\Appui\Note;
use bbn\File\System;
use bbn\Appui\Tag;
use bbn\Appui\Event;

//$articles = $model->db->count('articles');
$opt =& $model->inc->options;
$noteCls = new Note($model->db);
$fs = new System();
$tagCls = new Tag($model->db, defined('BBN_LANG') ? BBN_LANG : null);
$eventCls = new Event($model->db);

if ($model->data['action'] == 'undo') {
  $idsPosts = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_posts.json'), true);
  $deleted = 0;
  foreach ($idsPosts as $idPost) {
    $deleted += $model->db->delete('bbn_notes_tags', ['id_note' => $idPost]);
    $deleted += $model->db->delete('bbn_notes_medias', ['id_note' => $idPost]);
    $deleted += $model->db->delete('bbn_notes_events', ['id_note' => $idPost]);
    $deleted += $model->db->delete('bbn_notes_url', ['id_note' => $idPost]);
    $deleted += $model->db->delete('bbn_notes_versions', ['id_note' => $idPost]);
    $deleted += $model->db->delete('bbn_notes', ['id' => $idPost]);
  }

  return [
    'success' => true,
    'message' => X::_("Deleted %d rows.", $deleted)
  ];
}
else {
  $idsCatgs = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_categories.json'), true);
  $idsTags = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_tags.json'), true);
  $idsMedias = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_medias.json'), true);
  $categories = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'categories.json'), true);
  $tags = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'tags.json'), true);
  $authors = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'authors.json'), true);
  $posts = $fs->getFiles(APPUI_NOTE_CMS_IMPORT_PATH.'posts');
  $postsCats = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'posts_categories.json'), true);
  $postsTags = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'posts_tags.json'), true);
  $postsMedias = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'posts_medias.json'), true);
  $cfg = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'cfg.json'), true);
  $baseUrl = $cfg['baseUrl'];
  $idsPosts = [];
  $idsAuthors = [];
  $pubEventType = $model->inc->options->fromCode('publication', 'types', 'event', 'appui');

  if (!empty($posts)) {
    foreach ($posts as $postFile) {
      //die(var_dump(json_decode($fs->getContents($postFile))->bbn_cfg));
      if (($post = json_decode($fs->getContents($postFile)))
        && !empty($post->id)
        && !empty($postsCats[$post->id])
        && ($idCat = $idsCatgs[$postsCats[$post->id][0]])
        // Note
        && ($idNote = $noteCls->insert([
          'title' => $post->title,
          'content' => json_encode($post->bbn_cfg, JSON_UNESCAPED_UNICODE),
          'id_type' => $idCat,
          'mime' => 'json/bbn-cms'
        ]))
      ) {
        $idsPosts[] = $idNote;

        // Creation date
        if (!empty($post->postDate)) {
          $model->db->update('bbn_notes_versions', ['creation' => $post->postDate], ['id_note' => $idNote]);
        }

        // Categories
        foreach ($postsCats[$post->id] as $c) {
          if ($catText = $categories[$c]) {
            $t = $tagCls->get($catText);
            $idTag = empty($t) ? $tagCls->add($catText) : $t['id'];
            if (!empty($idTag)) {
              $idsTags[$c] = $idTag;
              $model->db->insertIgnore('bbn_notes_tags', ['id_note' => $idNote, 'id_tag' => $idTag]);
              $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_tags.json', json_encode($idsTags, JSON_PRETTY_PRINT));
            }
          }
        }

        // Tags
        foreach ($postsCats[$post->id] ?? [] as $t) {
          if (!empty($idsTags[$t])) {
            $model->db->insertIgnore('bbn_notes_tags', ['id_note' => $idNote, 'id_tag' => $idsTags[$t]]);
          }
        }

        // Medias
        foreach ($postsMedias[$post->id] ?? [] as $m) {
          if (!empty($idsMedias[$m])) {
            $noteCls->addMediaToNote($idsMedias[$m], $idNote);
          }
        }

        // Author
        if (!empty($post->author)
          && !empty($authors[$post->author])
        ) {
          $idAuthor = $idsAuthors[$post->author] ?? false;
          if (empty($idAuthor)
            && ($idAuthor = $model->db->selectOne('bbn_users', 'id', ['email' => $authors[$post->author]]))
          ) {
            $idsAuthors[$post->author] = $idAuthor;
          }

          if (!empty($idAuthor)) {
            $model->db->update('bbn_notes', ['creator'=> $idAuthor], ['id' => $idNote]);
            $model->db->update('bbn_notes_versions', ['id_user' => $idAuthor], ['id_note' => $idNote]);
          }
        }

        // Publication
        if (!empty($pubEventType)
          && ($post->status === 'publish')
          && !empty($post->pubDate)
          && ($idEvent = $eventCls->insert([
            'id_type' => $pubEventType,
            'start' => $post->pubDate
          ]))
        ) {
          $noteCls->insertNoteEvent($idNote, $idEvent);
        }

        // URL
        if (!empty($post->url)) {
          $url = $post->url;
          if (str_starts_with($url, $baseUrl)) {
            $url = substr($url, strlen($baseUrl));
            if (strpos($url, '/') === 0) {
              $url = substr($url, 1);
            }
          }
          $noteCls->insertOrUpdateUrl($idNote, $url);
        }

      }
    }
  }

  $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_posts.json', json_encode($idsPosts, JSON_PRETTY_PRINT));

  return [
    'success' => true,
    'message' => X::_("Process launch successfully, %d posts inserted.", count($idsPosts))
  ];


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
        $id_note = $noteCls->insert([
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
                $noteCls->addMediaToNote($id_media, $id_note, 1);
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
            $noteCls->addTag($id_note, $tag['value'], 'en');
          }
        }
      }
    }
  }

  //INSERTS ALL ATTACHMENTS IN MEDIA
  return ['message' => "Process launch successfully, $num notes inserted"];
}