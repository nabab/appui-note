<?php
use bbn\X;
use bbn\File\System;

$fs = new System();
if ($model->data['action'] === 'undo') {
  $deleted = 0;
  if (is_file(APPUI_NOTE_CMS_IMPORT_PATH.'ids_tags.json')) {
    $idsTags = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_tags.json'), true);
    foreach ($idsTags as $idTag) {
      if ($model->db->delete('bbn_tags', ['id' => $idTag])) {
        $deleted++;
      }
    }
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'ids_tags.json');
  }
  return [
    'success' => true,
    'message' => X::_("Deleted %d tags.", $deleted)
  ];
}
else {
  if (is_file(APPUI_NOTE_CMS_IMPORT_PATH.'tags.json')) {
    $tags = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'tags.json'));
    $idsTags = [];
    $added = 0;
    if (!empty($tags)) {
      foreach ($tags as $code => $text) {

        
      }

      if ($fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_tags.json', json_encode($idsTags, JSON_PRETTY_PRINT))) {
        return [
          'success' => true,
          'message' => X::_("Process launch successfully, added %d tags of %d.", $added, count($idsTags))
        ];
      }
    }
  }
}
