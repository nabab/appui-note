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
      if (($mediaUrl = $medias->getUrl($idMedia))
        && $fs->exists(BBN_PUBLIC.$mediaUrl)
      ) {
        $fs->delete(BBN_PUBLIC.$mediaUrl);
      }
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
              $url = Str::sub($url, Str::len($cfg['baseUrl']));
              if (Str::pos($url, '/') === 0) {
                $url = Str::sub($url, 1);
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
}
