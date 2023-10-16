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
    return ['message' => $i ? 'Process undo successfully, folder deleted' : 'No folder to delete'];
  }
  else {
    $st = file_get_contents(APPUI_NOTE_CMS_IMPORT_PATH.$model->data['file']['name']);
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
        file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'xml/item-'.$num.'.xml', $tmp);
      }
    }
    return [
      'success' => true,
      'message' => 'Process launch successfully, '.count($res).' files created'
    ];
  }
}
