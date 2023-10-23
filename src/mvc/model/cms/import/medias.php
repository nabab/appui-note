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
use bbn\File\System;
use bbn\Appui\Medias;

$fs = new System();
$medias = new Medias($model->db);
if ($model->data['action'] === 'undo') {
  $deleted = 0;
  if (is_file(APPUI_NOTE_CMS_IMPORT_PATH.'ids_medias.json')) {
    $idsMedias = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_medias.json'), true);
    foreach ($idsMedias as $idMedia) {
      if ($medias->delete($idMedia)) {
        $deleted++;
      }
    }
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'ids_medias.json');
    if ($fs->exists(APPUI_NOTE_CMS_IMPORT_PATH.'medias')) {
      $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'medias', true);
    }
  }
  return [
    'success' => true,
    'message' => X::_("Deleted %d medias.", $deleted)
  ];
}
else {
  // the two domains of squarespace
  $agent = 'Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36';
  $mediasList = array_values(array_unique(X::mergeArrays(
    json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'medias.json'), true),
    json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'medias2.json'), true)
  )));
  $cfg = $fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'cfg.json');
  $path = APPUI_NOTE_CMS_IMPORT_PATH.'medias/';
  if ($fs->exists($path)) {
    $fs->delete($path, true);
  }
  $found = 0;
  $lost = 0;
  if (is_array($mediasList)
    && !empty($cfg)
    && $fs->createPath($path)
  ) {
    $cfg = json_decode($cfg, true);
    if (!empty($cfg['baseUrl'])) {
      $idsMedias = [];
      foreach ($mediasList as $media) {
        $content = X::curl($media, [], [
          'useragent' =>  $agent,
          'followlocation' => true
        ]);
        if (($filename = basename(urldecode($media)))
          && !empty($content)
          && (X::lastCurlCode() === 200)
        ) {
          if (!$fs->putContents($path.$filename, $content)) {
            $lost++;
            throw new \Exception("Impossible to put the content in ".$path.$filename);
          }
          if (is_file($path.$filename)
            && ($idMedia = $medias->insert($path.$filename))
          ) {
            $found++;
            $url = urldecode($media);
            if (str_starts_with($url, $cfg['baseUrl'])) {
              $url = substr($url, strlen($cfg['baseUrl']));
              if (strpos($url, '/') === 0) {
                $url = substr($url, 1);
              }
            }
            $medias->setUrl($idMedia, $url);
            $idsMedias[$media] = $idMedia;
            continue;
          }
        }
        $lost++;
      }
      $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_medias.json', json_encode($idsMedias, JSON_PRETTY_PRINT));
    }
  }

  return [
    'success' => true,
    'message' => X::_("Process launch successfully, %d medias not found vs %d found", $lost, $found)
  ];





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
