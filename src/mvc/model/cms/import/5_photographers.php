<?php
use bbn\X;

if($model->data['action'] == 'undo') {
  $num = $model->db->delete('photographers', []);
  return ['message' => "Process undo successfully, $num rows deleted."];
}
else {
  //insert photographers in db scanning the json files created before
  $n = 0;
  $path = BBN_DATA_PATH.'photographers/';
  if (is_dir($path)
      && ($ph = scandir($path))
      && ($authors = file_get_contents(BBN_DATA_PATH.'content/blocks/marine-03045.json'))
  ) {
    $opt = $model->inc->options;
    $notes = new bbn\Appui\Note($model->db);
    $data = json_decode($authors, true);
    $blocks = json_decode($data['bbn_cfg'], true);
    $res = [];
    $cat_idx = null;
    $current_category = '';
    $photographers = [];
    $categories = ['1840-1949' => $opt->fromCode('1840-1949', 'article_cats')];
    //detect the photographer's period basing on the title of the section in squarespace's article
    foreach ($blocks as $i => $b ) {
      if (($b['type'] === 'title') && ($b['tag'] === 'h3')) {
        $current_category = $b['content'];
        $code = strtolower(str_replace(' ', '-', $current_category));
        $categories[$current_category] = $opt->fromCode($code, 'article_cats');
        $cat_idx = $i;
      }

      if (($cat_idx !== null) && ($i === $cat_idx +2 )){
        $photographers[$current_category][] = $blocks[$i]['source'];
      }
      //the last block of photographers has no title, just a description
      if( ($blocks[$i]['type'] === 'gallery') && ( $blocks[$i -2]['type'] !== 'title') ){
        $photographers['1840-1949'][] =  $blocks[$i]['source'];
      }
    }
    foreach ($photographers as $cat => $p) {
      foreach ($p as $ph) {
        foreach ($ph as $url) {
          $res[] = [
            'name' => $url['caption'],
            'url' => urldecode($url['href']),
            'front_img' => $url['src'],
            'category' => $categories[$cat]
          ];
        }
      }
    }

    //IMPORTANT, JUST FOR THE )FIRST TIME NEED TO REMOVE THE OLD DOMAIN FROM THE SRC
    $model->db->delete('photographers', []);
    foreach($res as $r){
      if( $article = $model->db->rselect('articles', [],['url'=> $r['url']])){
        //craetes a new note for the photographer inserting the array of id_medias as content
        $n += (int)$model->db->insert('photographers', [
          'id_note' => null,
          'url' => $r['url'],
          'cfg' => '[]',
          'type' => $article['type'],
          'title' => $r['name'],
          'num_media' => 0,
          'description' => $article['excerpt'],
          'category' => $r['category'],
          'front_img' => $r['front_img']
        ]);
      }
    }
  }

  return ['message' => "Process launch successfully, $n rows inserted."];
}
