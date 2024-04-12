<?php
use bbn\X;

if ( !empty($ctrl->arguments[0]) ) {
  $ctrl->addData([
    'url' => X::join($ctrl->arguments, '/')
  ]);
  $ctrl->addJs($ctrl->pluginUrl('appui-note').'/cms/preview/index', $ctrl->getModel());
  echo $ctrl->addData(['script' => $ctrl->getView('', 'js')])
            ->addData(['data' => $ctrl->getModel()])
            ->getView()
              .PHP_EOL.'<style>'.$ctrl->getLess().'</style>';
  //$ctrl->combo('preview', true);
}