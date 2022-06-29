<?php

/** @var $ctrl \bbn\Mvc\Controller */

if ($ctrl->hasArguments()) {
  $ctrl->addData(['types' => [$ctrl->arguments[0]]]);
}

$ctrl->action();
