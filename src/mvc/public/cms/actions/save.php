<?php
/** @var $ctrl \bbn\Mvc\Controller */
if ($m = $ctrl->getPluginModel('cms/actions/save', $ctrl->post)) {
  $ctrl->obj = $m;
}
else{
  $ctrl->action();
}

