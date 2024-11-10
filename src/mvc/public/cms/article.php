<?php

/** @var bbn\Mvc\Controller $ctrl */

if ($ctrl->hasArguments()) {
	$ctrl->addData(['id' => $ctrl->arguments[0]])
    ->combo('$title', true);
}
else {
  echo _('No arguments');
}