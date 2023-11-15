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
$replaceExists = false;

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
  $defaultCat = $model->inc->options->fromCode('post', 'types', 'note', 'appui');

  if (!empty($posts)) {
    foreach ($posts as $postFile) {
      if (($post = json_decode($fs->getContents($postFile)))
        && !empty($post->id)
      ) {
        $idCat = empty($postsCats[$post->id]) ? $defaultCat : $idsCatgs[$postsCats[$post->id][0]];
        if (!empty($idCat)) {
          // URL
          $url = false;
          if (!empty($post->url)) {
            $url = $post->url;
            if (str_starts_with($url, $baseUrl)) {
              $url = substr($url, strlen($baseUrl));
              if (strpos($url, '/') === 0) {
                $url = substr($url, 1);
              }
            }
          }

          $idNote = false;
          if (!empty($replaceExists)
            && ($idNote = $noteCls->urlToId($url))
          ) {
            $model->db->update('bbn_notes_versions', [
              'title' => $post->title,
              'content' => json_encode($post->bbn_cfg, JSON_UNESCAPED_UNICODE)
            ], [
              'id_note' => $idNote,
              'latest' => 1
            ]);
          }
          else if (empty($url) || !$noteCls->urlToId($url)) {
            $idNote = $noteCls->insert([
              'title' => $post->title,
              'content' => json_encode($post->bbn_cfg, JSON_UNESCAPED_UNICODE),
              'id_type' => $idCat,
              'mime' => 'json/bbn-cms'
            ]);
          }

          if (!empty($idNote)) {
            $idsPosts[] = $idNote;

            // Set URL
            if (!empty($url) && !$noteCls->urlExists($url)) {
              $noteCls->insertOrUpdateUrl($idNote, $url);
            }

            // Creation date
            if (!empty($post->postDate)) {
              $model->db->update('bbn_notes_versions', ['creation' => $post->postDate], ['id_note' => $idNote]);
            }

            // Categories
            foreach ($postsCats[$post->id] as $c) {
              if (isset($categories[$c])) {
                $t = $tagCls->get($categories[$c]);
                $idTag = empty($t) ? $tagCls->add($categories[$c]) : $t['id'];
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
            if (empty($replaceExists)
              && !empty($pubEventType)
              && ($post->status === 'publish')
              && !empty($post->pubDate)
              && ($idEvent = $eventCls->insert([
                'id_type' => $pubEventType,
                'start' => $post->pubDate
              ]))
            ) {
              $noteCls->insertNoteEvent($idNote, $idEvent);
            }
          }
        }
      }
    }
  }

  $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_posts.json', json_encode($idsPosts, JSON_PRETTY_PRINT));

  return [
    'success' => true,
    'message' => X::_("Process launch successfully, %d posts inserted.", count($idsPosts))
  ];
}