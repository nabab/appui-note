<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\Mvc\Controller 
 *
 */
use bbn\X;

if ( !empty($ctrl->arguments[0]) ) {
  $ctrl->addData([
    'url' => X::join($ctrl->arguments, '/')
  ]);
  echo $ctrl->getView()
    .$ctrl->getJs(APPUI_NOTE_ROOT.'cms/preview/index', $ctrl->getModel())
    .PHP_EOL.'<style>'.$ctrl->getLess().'</style>';
  //$ctrl->combo('preview', true);
}