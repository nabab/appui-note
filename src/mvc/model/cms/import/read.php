<?php
/*
  ###IMPORTANT###
  before to begin the process:
    - empty the tables of database
    - empty the folder data/photographers (create if doen't exist)
    - empty the folder data/tmp_medias (create if doen't exist)
  */
//CREATES ONE FILE HTML FOREACH ARTICLE IN THE XML

use bbn\X;
use bbn\File\System;

if (defined('APPUI_NOTE_CMS_IMPORT_PATH')
  && $model->hasData('file')
) {
  $fs = new System();
  if ($model->data['action'] == 'undo') {
    $i = $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'xml/', true);
    return [
      'message' => $i ? X::_('Process undo successfully, folder deleted') : X::_('No folder to delete')
    ];
  }
  else {
    $st = $fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.$model->data['file']['name']);
    $xml = XMLReader::XML($st);
    $cfgFile = APPUI_NOTE_CMS_IMPORT_PATH.'cfg.json';
    $baseUrlReg = '/\<wp\:base\_site\_url\>(.*)\<\/wp\:base\_site\_url\>/';
    preg_match($baseUrlReg, $st, $baseUrlMatch);
    if (!empty($baseUrlMatch[1])
      && is_file($cfgFile)
      && ($cfg = $fs->getContents($cfgFile))
      && ($cfg = json_decode($cfg, true))
    ) {
      $cfg['baseUrl'] = $baseUrlMatch[1];
      $authorsReg = '/\<wp\:author\>.*\<wp\:author\_login\>\<\!\[CDATA\[(.*)\]\]\>\<\/wp\:author\_login\>.*\<wp\:author\_email\>\<\!\[CDATA\[(.*)\]\]\>\<\/wp\:author\_email\>/';
      preg_match_all($authorsReg, $st, $authorsMatch, PREG_SET_ORDER);
      $authors = [];
      if (!empty($authorsMatch)) {
        foreach ($authorsMatch as $am) {
          if (!empty($am[1]) && !empty($am[2])) {
            $authors[$am[1]] = $am[2];
          }
        }
      }
      $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'authors.json', json_encode($authors, JSON_PRETTY_PRINT));
      $fs->putContents($cfgFile, json_encode($cfg, JSON_PRETTY_PRINT));
      $bits = X::split($st, '<item>');
      $res = [];
      if ($fs->exists(APPUI_NOTE_CMS_IMPORT_PATH.'xml/')) {
        $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'xml/', true);
      }
      $fs->createPath(APPUI_NOTE_CMS_IMPORT_PATH.'xml');
      $i = 0;
      foreach ($bits as $b) {
        $pos = X::indexOf($b, '</item>');
        if ($pos > -1) {
          $i++;
          $tmp = substr($b, 0, $pos);
          $res[] = $tmp;
          $num = str_pad((string)($i), 5, '0', STR_PAD_LEFT);
          $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'xml/item-'.$num.'.xml', $tmp);
        }
      }
      return [
        'success' => true,
        'message' => X::_("Process launch successfully, %d files created", count($res))
      ];
    }
  }
}
