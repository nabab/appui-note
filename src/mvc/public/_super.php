<?php
/** @var bbn\Mvc\Controller $ctrl */
if ( !\defined('APPUI_NOTE_ROOT') ){
  define('APPUI_NOTE_ROOT', $ctrl->pluginUrl('appui-note').'/');
}
if (empty($ctrl->post)) {
  $ctrl->addData(['root' => APPUI_NOTE_ROOT]);
}
