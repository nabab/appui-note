<?php

/** @var bbn\Mvc\Controller $ctrl */

if ($ctrl->hasArguments()) {
  $ctrl->addData(['types' => [$ctrl->arguments[0]]]);
}

$ctrl->action();
