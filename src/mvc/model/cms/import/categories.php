<?php
use bbn\X;
use bbn\File\System;

$fs = new System();
if ($model->data['action'] === 'undo') {
  $deleted = 0;
  $idsCats = [];
  if (is_file(APPUI_NOTE_CMS_IMPORT_PATH.'ids_categories.json')) {
    $idsCats = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_categories.json'), true);
    foreach ($idsCats as $idCat) {
      if ($model->inc->options->removeFull($idCat)) {
        $deleted++;
      }
    }

    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'ids_categories.json');
  }

  return [
    'success' => true,
    'message' => X::_("Deleted %d of %d categories.", $deleted, count($idsCats))
  ];
}
else {
  if (is_file(APPUI_NOTE_CMS_IMPORT_PATH.'categories.json')) {
    $cats = json_decode($fs->getContents(APPUI_NOTE_CMS_IMPORT_PATH.'categories.json'));
    $idsCats = [];
    $added = 0;
    if (!empty($cats)) {
      $idAlias = $model->inc->options->fromCode('bbn-cms', 'editors', 'note', 'appui');
      if (empty($idAlias)) {
        throw new \Exception(_("No bbn-cms editor"));
      }

      $idParent = $model->inc->options->fromCode('types', 'note', 'appui');
      if (empty($idParent)) {
        throw new \Exception(_("No note types option"));
      }

      foreach ($cats as $code => $text) {
        if ($idCat = $model->inc->options->fromCode($code, $idParent)) {
          if (!isset($idsCats[$code])) {
            $idsCats[$code] = $idCat;
          }
        }
        else {
          if ($idCat = $model->inc->options->add([
            'id_parent' => $idParent,
            'id_alias' => $idAlias,
            'code' => $code,
            'text' => normalizer_normalize($text)
          ])) {
            $added++;
            if (!isset($idsCats[$code])) {
              $idsCats[$code] = $idCat;
            }
          }
        }
      }

      if ($fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids_categories.json', json_encode($idsCats, JSON_PRETTY_PRINT))) {
        return [
          'success' => true,
          'message' => X::_("Process launch successfully, added %d categories of %d.", $added, count($idsCats))
        ];
      }
    }
  }
}
