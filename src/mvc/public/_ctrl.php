<?php
/** @var $ctrl \bbn\Mvc\Controller */
if ( !\defined('APPUI_NOTES_ROOT') ){
  define('APPUI_NOTES_ROOT', $ctrl->pluginUrl('appui-note').'/');
}
$ctrl->data['root'] = $ctrl->pluginUrl('appui-note').'/';
