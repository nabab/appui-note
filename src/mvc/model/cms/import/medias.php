<?php
//TO FIND DUPLICATES NAME AND OLD_URL IN BBN_MEDIAS
/*SELECT
      old_url,
      COUNT(old_url),
      name, COUNT(name)
  FROM
      bbn_medias
  GROUP BY old_url, name
  HAVING COUNT(old_url) > 1
      AND COUNT(name) > 1
  */
//creates the file media for the articles type attachment and inserts it in bbn_medias (the old url is recorded in bbn_medias )

use bbn\X;
use bbn\Str;
$st = 'Set In Stone-14';
$id_post_cat = $model->inc->options->fromCode('post', 'types', 'notes');
$fs = new bbn\File\System();
if ($model->data['action'] === 'undo') {
  $model->db->delete('bbn_medias_url', []);
  $num = $model->db->delete('bbn_medias', []);
  $num_files = $fs->delete($model->contentPath('appui-note').'media/2021', true);
  return ['message' => "Deleted $num medias and $num_files files"];
}
else {
  $medias = new \bbn\Appui\Medias($model->db);
  // the two domains of squarespace
  $oldDomain = 'https://images.squarespace-cdn.com';
  $oldDomain2= 'http://static1.squarespace.com';
  $agent = 'Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36';
  $q = $model->db->query("SELECT * FROM articles");
  $folder = BBN_DATA_PATH.'content/20211008/';
  \bbn\File\Dir::createPath(BBN_DATA_PATH.'photographers');
  $fs->cd($folder);
  $all = $fs->getFiles('.');
  $lost = 0;
  $found = 0;
  while($a = $q->getRow()) {
    //  This is not a post but an attachment

    if ($a['type'] === 'attachment') {
      $url = urldecode($a['url']);
      $pi = X::pathinfo($url);
      $filename = $pi['basename'];
      $file = substr($url, 1);
      $ext = $pi['extension'];

      // If no extension of record already in URL we pass
      if (!$ext || $model->db->count('bbn_medias_url', ['url' => $url])) {
        continue;
      }

      // We don't care about a string starting with attachment, which is the default
      if (strpos($a['title'], 'attachment') === 0) {
        $a['title'] = '';
      }

      // We don't care about a string starting with exc-, which is the automatically generated
      if (strpos($a['excerpt'], 'exc-') === 0) {
        $a['excerpt'] = null;
      }

      // Where the file should be
      $path = $folder.$file;
      $fs->createPath(X::dirname($path));

      if (!file_exists($path)) {
        if ((
          ($content = X::curl($oldDomain.$a['url'], [], ['useragent' =>  $agent, 'followlocation' => true]))
          && (X::lastCurlCode() === 200)
        ) || (
          ($content = X::curl($oldDomain2.$a['url'], [], ['useragent' =>  $agent, 'followlocation' => true]))
          && (X::lastCurlCode() === 200)
        )){
          X::adump('attachment ok: '.$file);
          if (!file_put_contents($path, $content)) {
            throw new \Exception("Impossible to put the content in ".$file);
          }
        }
      }

      if (file_exists($path)) {
        $found++;
        if ($id = $medias->insert(
          $path,
          [],
          $a['title'],
          'file',
          false,
          $a['excerpt']
        )
           ) {
          $medias->setUrl($id, $url);
        }
        else {
          throw new \Exception("Impossible to insert in db ".$path);
        }
      }
      else {
        $lost++;
        X::adump("File $path does not exists");
        //X::ddump("File $path does not exists");
      }
    }
    //inserts the media contained in the page and post
    else {
      if( !empty($a['bbn_cfg']) ){
        $cfg = json_decode($a['bbn_cfg'], true);
        $images = [];
        foreach( $cfg as $c ){
          switch ($c['type']){
            case 'carousel':
            case 'gallery':
              foreach( $c['source'] as $src ){
                $images[] = $src['src'];
              }
              break;
            case 'image':
              $images[] = $c['src'];
              break;
          }
        }
        $res = [];
        //creates a json file for each page containing the src of images
        if ( !empty($images) ){

          //photographers indexed by title
          //photographers indexed by name

          //using urlencode($a['name']) to create the file in photographers because name as 'exhibition-highlight-love-ren-hang-at-c/o-berlin-foundation' blocks the script

          if( file_put_contents(BBN_DATA_PATH.'photographers/'.urlencode($a['name']).'.json', json_encode($images))){
            //creates the media of images in page and post
            foreach($images as $old_url){
              $pi = X::pathinfo($old_url);
              $ext = $pi['extension'];
              $name = substr($old_url, 1);
              $decoded = urldecode($name);
              $is_encoded = $decoded !== $name;
              /*
                          if (stripos($name, '-'.$ext ) !== false ) {
                              $name = str_ireplace('-'.$ext, '', $name);
                          }
                          */
              //SHOULD REMOVE THE WHOLE MEDIA, NOT ONLY THE ROW
              /*
                          if( $old_media = $model->db->rselectAll('bbn_medias_url', [], ['old_url' => urldecode($old_url), 'name'=> $decoded])){
                              foreach($old_media as $old){
                                  $model->db->delete('bbn_medias', ['id'=> $old['id_media']]);
                                  $model->db->delete('bbn_medias_url', ['id'=> $old['id']]);
                              }
                          }
                          */
              $path = "{$folder}/{$decoded}";
              $fs->createPath(X::dirname($path));
              if (!file_exists($path)) {
                //curl returned false in some image because it's going to take the image from the old_url without the domain name!!!
                //IT WILL NOT WORK AFTER REMOVING DOMAIN FROM URL
                if (
                  (
                    ( $content2 = X::curl($oldDomain.$old_url,[], ['useragent' =>  $agent, 'followlocation' => true])) &&
                    ( X::lastCurlCode() === 200)
                  ) ||
                  (
                    ($content2 = X::curl($oldDomain2.$old_url,[], ['useragent' =>  $agent, 'followlocation' => true])) &&
                    ( X::lastCurlCode() === 200)
                  )
                ) {
                  file_put_contents($path, $content2);
                }
              }

              if (file_exists($path)) {
                $found++;
                if (!$model->db->count('bbn_medias_url', ['url' => urldecode($old_url)])) {
                  $id_media = $medias->insert(
                    $path,
                    [],
                    '',
                    'file',
                    false
                  );
                  //X::log( [$a['type']=>$a['id'] ],'id_media');
                  if ( !empty($id_media) ) {
                    $medias->setUrl($id_media, urldecode($old_url), 1);
                  }
                }
                else {
                  X::adump('no media inserted: '.$decoded);
                  X::log($decoded, 'media_errors');
                  //throw new \Exception('no media inserted: '.$decoded);
                }
              }
              elseif ($ext !== 'gif') {
                $lost++;
                X::adump("File does not exist ?", $folder.$decoded.'.'.$ext, file_exists($folder.$decoded.'.'.$ext));
                //X::ddump("File does not exist ?", $folder.$decoded.'.'.$ext, file_exists($folder.$decoded.'.'.$ext));
              }
              else {
                X::log($decoded, 'media_errors');
              }
            }
          }
          else{
            X::adump('no content inserted: '.$decoded);
            throw new \Exception('no content inserted: '.$decoded);
          }
        }
      }
    }
  }
  X::adump("$a[id] of type $a[type] started");
  return ['message' => 'Process launch successfully, '.$lost.' images not found vs '.$found.' found'];
  /*if($a['id'<= 1078]){
            continue;
        }*/
}
