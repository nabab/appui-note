<?php
/** @var $ctrl \bbn\mvc\controller */
if ( !\defined('APPUI_NOTES_ROOT') ){
  define('APPUI_NOTES_ROOT', $ctrl->plugin_url('appui-notes').'/');
}
$ctrl->data['root'] = $ctrl->plugin_url('appui-notes').'/';
