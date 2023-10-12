<?php
use bbn\X;

//insert categories
if ($model->data['action'] === 'undo') {
  $num = $model->db->delete('articles', []);
  if (is_file(BBN_DATA_PATH.'categories.json') && !empty(file_get_contents(BBN_DATA_PATH.'categories.json'))) {
    $categories = json_decode(file_get_contents(BBN_DATA_PATH.'categories.json'), true);
    if (!empty($categories) && !empty($categories['cats'])) {
      foreach ( $categories['cats'] as $code => $name ) {
        $num += (int)$model->db->insertIgnore('categories', ['name' => $code, 'title' => $name]);
      }

      $categories['cats'] = $model->db->selectAllByKeys('categories', ['name', 'id']);
    }
  }

  return ['message' => 'Process undo successfully, '.$num.' records deleted'];
}
else {
  //INSERT ARTICLES IN DB AND CATEGORY IN ARTICLE_CATEGORIES
  if (
    ($articles = scandir(BBN_DATA_PATH.'content/blocks/')) &&
    ($ids = json_decode( file_get_contents(BBN_DATA_PATH.'ids2.json'), true ))
  ) {
    foreach($articles as $idx => $article ){
      $r = json_decode(file_get_contents(BBN_DATA_PATH.'content/blocks/'.$article), true);
      if (strpos($article, '.') !== 0 ) {
        if ( ( (!isset($r['parent'])) || ($r['parent'] === null) ) && ($r['type'] === 'attachment') ){
          $parent = $ids[$r['id']];
        }
        else{
          $parent = $r['parent'];
        }
        if ( isset($r['id']) && !empty($r['type']) ){
          if ( !empty($r['attachment']) ){
            //removes the old domain from attachment
            $old = 'http://static1.squarespace.com';
            $old2 = 'https://images.squarespace-cdn.com';
            if ( strpos($r['attachment'],$old) !== false){
              $r['attachment'] = str_replace($old, '', $r['attachment']);
            }
            else if( strpos($r['attachment'],$old2) !== false){
              $r['attachment'] = str_replace($old2, '', $r['attachment']);
            }
          }
          if ( !empty($r['url']) ){
            //removes the old domain from url
            $old = 'http://static1.squarespace.com';
            $old2 = 'https://images.squarespace-cdn.com';
            if ( strpos($r['url'],$old) !== false){
              $r['url'] = str_replace($old, '', $r['url']);
            }
            else if( strpos($r['url'],$old2) !== false){
              $r['url'] = str_replace($old2, '', $r['url']);
            }
          }


          $num += (int)$model->db->insertUpdate('articles', [
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
            'photographer' => $r['photographer'],
            'tags' => !empty($r['tags']) ? json_encode($r['tags']) : null,
            'comment' => !empty($r['comments']) ? json_encode($r['comments']) : null,
            'comment_status' => $r['comment_status'],
            'bbn_cfg' => $r['bbn_cfg'], 
            'bbn_elements' => $r['bbn_elements'] ?: null
          ]);
          if (!empty($r['categories'])) {
            foreach ($r['categories'] as $i => $c){
              $num += (int)$model->db->insertIgnore('articles_categories', [
                'id_article' => $r['id'],
                'id_category' => $model->db->selectOne('categories', 'id', ['name' => $c['code']])
              ]);
            }
          }
        }
        else if ( empty($r['type']) ){
          X::log('no - '.$r['id']);
        }


      }
    }

    //removes the old domains in article cols bbn_cfg e bbn_elements
    $old = '%https://images.squarespace-cdn.com/%';
    $old2 = '%http://static1.squarespace.com%';
    $articles = $model->db->rselectAll('articles', [], ['bbn_cfg' => $old]);
    $articles2 =  $model->db->rselectAll('articles', [], ['bbn_cfg' => $old2]);
    foreach ( $articles as $a ) {
      $old = 'https://images.squarespace-cdn.com';
      $escaped = 'https:\/\/images.squarespace-cdn.com';
      $new_cfg = str_replace($escaped,'',$a['bbn_cfg']);
      $new_bbn_elements = str_replace($old, '', $a['bbn_elements']);


      $model->db->update('articles', [
        'bbn_cfg' => $new_cfg,
        'bbn_elements' => $new_bbn_elements
      ], [ 'id'=> $a['id'] ]);

    }
    foreach ( $articles2 as $a ) {
      $escaped = 'http:\/\/static1.squarespace.com';
      $old = 'http://static1.squarespace.com';
      $new_cfg = str_replace($escaped,'',$a['bbn_cfg']);
      $new_bbn_elements = str_replace($old, '', $a['bbn_elements']);

      $model->db->update('articles', [
        'bbn_cfg' => $new_cfg,
        'bbn_elements' => $new_bbn_elements
      ], [ 'id'=> $a['id'] ]);
      X::log($a['id'],'imgs');
    }
    return ['message' => 'Process launch successfully, '.$num.' rows created'];
  }

  return ['message' => 'Problem during the launch process'];
}


