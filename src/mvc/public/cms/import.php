<?php

use bbn\X;
use bbn\File\System;

if (!defined('APPUI_NOTE_CMS_IMPORT_PATH')) {
  define('APPUI_NOTE_CMS_IMPORT_PATH', $ctrl->pluginDataPath().'import/');
}

$fs = new System();
if (!$fs->exists(APPUI_NOTE_CMS_IMPORT_PATH)) {
  $fs->createPath(APPUI_NOTE_CMS_IMPORT_PATH);
}
$cfgFile = APPUI_NOTE_CMS_IMPORT_PATH.'cfg.json';

if (!empty($ctrl->post['action'])
  && ($ctrl->post['action'] === 'reset')
) {
  $ctrl->obj->success = $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH, true);
}
else if (!empty($ctrl->post['process'])
  && !empty($ctrl->post['action'])
  && !empty($ctrl->post['file']['name'])
  && is_file(APPUI_NOTE_CMS_IMPORT_PATH.$ctrl->post['file']['name'])
) {
  if (!is_file($cfgFile)) {
    file_put_contents($cfgFile, json_encode([
      'creationDate' => date('Y-m-d H:i:s'),
      'file' => $ctrl->post['file'],
      'processes' => []
    ], JSON_PRETTY_PRINT));
  }

  /** @var array array with index creationDate and processes */
  $jsonCfg = json_decode($fs->getContents($cfgFile), true);
  if ($jsonCfg['file'] == $ctrl->post['file']) {
    $pluginUrl = $ctrl->pluginUrl().'/';
    // if processes not exist we create the new process*/
    if (!isset($jsonCfg['processes'][$ctrl->post['process']])) {
      $jsonCfg['processes'][$ctrl->post['process']] = [
        'creationDate' => date('Y-m-d H:i:s')
      ];
    }
    // set the processes jsoncfg reference to $process
    $process =& $jsonCfg['processes'][$ctrl->post['process']];
    // write the last action information if is launch or undo
    switch ($ctrl->post['action']) {
      case 'launch':
        // modifying last launch value for the current process
        $process['launchDate'] = date('Y-m-d H:i:s');
        $fs->putContents($cfgFile, json_encode($jsonCfg, JSON_PRETTY_PRINT));
        // launch the controller of the given process in admin/import/
        $ctrl->obj->data = $ctrl->getModel($pluginUrl.'cms/import/'.$ctrl->post['process'], $ctrl->post);
        $jsonCfg = json_decode($fs->getContents($cfgFile), true);
        $process =& $jsonCfg['processes'][$ctrl->post['process']];
        if (!empty($ctrl->obj->data['success'])) {
          $process['done'] = true;
        }
        if (!empty($ctrl->obj->data['message'])) {
          $process['message'] = $ctrl->obj->data['message'];
        }
        break;

      case 'undo':
        $process['undoDate'] = date('Y-m-d H:i:s');
        $fs->putContents($cfgFile, json_encode($jsonCfg, JSON_PRETTY_PRINT));
        $ctrl->obj->data = $ctrl->getModel($pluginUrl.'cms/import/'.$ctrl->post['process'], $ctrl->post);
        $jsonCfg = json_decode($fs->getContents($cfgFile), true);
        $process =& $jsonCfg['processes'][$ctrl->post['process']];
        if (!empty($ctrl->obj->data['success'])) {
          $process['done'] = false;
        }
        if (!empty($ctrl->obj->data['message'])) {
          $process['message'] = $ctrl->obj->data['message'];
        }
        break;

      case 'info':
        $ctrl->obj = X::toObject($process);
        break;
    }

    $ctrl->obj->cfg = $jsonCfg;

    $fs->putContents($cfgFile, json_encode($jsonCfg, JSON_PRETTY_PRINT));
  }
}
else if (!empty($ctrl->files)) {
  $f = $ctrl->files['file'];
  $filename = !empty($_REQUEST['name']) && ($_REQUEST['name'] !== $f['name']) ?
    \bbn\Str::encodeFilename($_REQUEST['name'], \bbn\Str::fileExt($_REQUEST['name'])) :
    \bbn\Str::encodeFilename($f['name'], \bbn\Str::fileExt($f['name']));
  if (rename($f['tmp_name'], APPUI_NOTE_CMS_IMPORT_PATH.$filename)) {
    $ctrl->obj->success = 1;
    $ctrl->obj->fichier = [
      'name' => $filename,
      'size' => filesize(APPUI_NOTE_CMS_IMPORT_PATH.$filename),
      'extension' => '.'.\bbn\Str::fileExt($filename)
    ];
    file_put_contents($cfgFile, json_encode([
      'creationDate' => date('Y-m-d H:i:s'),
      'file' => $ctrl->obj->fichier,
      'processes' => [
        'file' => [
          'done' => true,
          'launchDate' => date('Y-m-d H:i:s'),
          'message' => _("Done")
        ]
      ]
    ], JSON_PRETTY_PRINT));
  }
}
else {
  $fs->cd($ctrl->pluginPath().'/mvc/model/cms/import');
  $d = [
    'cfg' => null,
    'filesList' => array_map(function($a){ return basename($a, '.php');}, $fs->getFiles('.'))
  ];
  if (is_file($cfgFile)) {
    $d['cfg'] = json_decode(file_get_contents($cfgFile), true);
  }

  $ctrl->combo('', $d);
}
