<?php
use bbn\X;
use bbn\File\Dir;
use bbn\File\System;

$fs = new System();

//insert categories
if ($model->data['action'] === 'undo') {
  Dir::delete(APPUI_NOTE_CMS_IMPORT_PATH.'posts', true);
  Dir::delete(APPUI_NOTE_CMS_IMPORT_PATH.'posts.json');
  Dir::delete(APPUI_NOTE_CMS_IMPORT_PATH.'posts_categories.json');
  Dir::delete(APPUI_NOTE_CMS_IMPORT_PATH.'medias2.json');
  return [
    'success' => true,
    'message' => _('Process undo successfully.')
  ];
}
else {
  //INSERT ARTICLES IN DB AND CATEGORY IN ARTICLE_CATEGORIES
  if (defined('APPUI_NOTE_CMS_IMPORT_PATH')
    && ($postsList = $fs->getFiles(APPUI_NOTE_CMS_IMPORT_PATH.'json'))
    && ($ids = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids.json'), true))
    && $fs->createPath(APPUI_NOTE_CMS_IMPORT_PATH.'posts')
  ) {
    $mediaRegex = '/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/(.*)/';
    $medias = [];
    $postsCategories = [];
    $postsTags = [];
    $made = 0;
    foreach ($postsList as $idx => $post) {
      $r = json_decode($fs->getContents($post), true);
      if ((!isset($r['parent']) || is_null($r['parent'])) && ($r['type'] === 'attachment')) {
        $parent = $ids[$r['id']];
      }
      else{
        $parent = $r['parent'];
      }

      if (isset($r['id']) && !empty($r['type'])) {
        if (!empty($r['attachment'])) {
          //removes the old domain from attachment
          preg_match($mediaRegex, $r['attachment'], $mediaMatches);
          if (!empty($mediaMatches[1])) {
            $medias[$mediaMatches[1]] = $r['attachment'];
            $r['attachment'] = 'media/'.$mediaMatches[1];
          }
        }

        if (!empty($r['url'])) {
          //removes the old domain from url
          preg_match($mediaRegex, $r['url'], $mediaMatches);
          if (!empty($mediaMatches[1])) {
            $medias[$mediaMatches[1]] = $r['url'];
            $r['url'] = 'media/'.$mediaMatches[1];
          }
        }
        if ($fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'posts/'.basename($post), json_encode([
          'id' => $r['id'],
          'title' => $r['title'],
          'url' => $r['url'],
          'author' => $r['author'],
          'pubDate' => $r['pubDate'],
          'postDate' => $r['postDate'],
          'postDateGMT' => $r['postDateGMT'],
          'name' => $r['name'],
          'type' => $r['type'],
          'attachment' => $r['attachment'],
          'parent' => $parent ?? null,
          'excerpt' => strip_tags($r['excerpt']),
          'content' => trim(preg_replace('/\s\s+/', ' ', $r['content'])),
          'description' => strip_tags(trim(preg_replace('/\s\s+/', ' ', $r['content']))),
          'status' => $r['status'],
          'tags' => !empty($r['tags']) ? json_encode($r['tags']) : null,
          'comment' => !empty($r['comments']) ? json_encode($r['comments']) : null,
          'comment_status' => $r['comment_status'],
          'categories' => empty($r['categories']) ? [] : array_map(fn($c) => $c['code'], $r['categories']),
          'bbn_cfg' => $r['bbn_cfg'],
          'bbn_elements' => $r['bbn_elements'] ?: null
        ], JSON_UNESCAPED_UNICODE))) {
          $made++;
          if (!empty($r['categories'])) {
            $postsCategories[$r['id']] = [];
            foreach ($r['categories'] as $i => $c){
              $postsCategories[$r['id']][] = $c['code'];
            }
          }
          if (!empty($r['tags'])) {
            $postsTags[$r['id']] = [];
            foreach ($r['tags'] as $i => $t){
              $postsTags[$r['id']][] = $t['code'];
            }
          }
        }
      }
      else if (empty($r['type'])) {
        X::log('no - '.$r['id']);
      }
    }

    file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'posts_categories.json', json_encode($postsCategories, JSON_PRETTY_PRINT));
    file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'posts_tags.json', json_encode($postsTags, JSON_PRETTY_PRINT));
    file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'medias2.json', json_encode($medias, JSON_PRETTY_PRINT));

    return [
      'success' => true,
      'message' => X::_("Process launch successfully, %d posts files created.", $made)
    ];
  }

  return [
    'message' => _('Problem during the launch process')
  ];
}


