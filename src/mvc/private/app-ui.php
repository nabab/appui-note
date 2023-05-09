<?php

/** @var bbn\Controller $ctrl The current controller */

use bbn\X;

$root = $ctrl->pluginUrl('appui-note');
$postItButton = $ctrl->add($root . '/app-ui/post-it/button', [], true);
$postItCp = $ctrl->add($root . '/app-ui/post-it/main', [], true);
$ctrl->obj->data = [
  'status' => $postItButton->obj,
  'after' => $postItCp->obj
];


