<?php

use bbn\Mvc;
/** @var bbn\Mvc\Model $model The current model */

//$postItButton = $model->get('./button', [], true);
//$postItCp = $model->addController('./main', [], true);
return [
  'status' => [
    'content' => Mvc::getInstance()->subpluginView('app-ui/button', 'html', [], 'appui-note', 'appui-core'),
    'script' => Mvc::getInstance()->subpluginView('app-ui/button', 'js', [], 'appui-note', 'appui-core'),
  ],
  'after' => [
    'content' => Mvc::getInstance()->subpluginView('app-ui/main', 'html', [], 'appui-note', 'appui-core'),
    'script' => Mvc::getInstance()->subpluginView('app-ui/main', 'js', [], 'appui-note', 'appui-core'),
  ]
];


