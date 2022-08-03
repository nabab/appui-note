<?php
/** @var \bbn\Mvc\Controller $ctrl */
if($m = $ctrl->getPluginModel('cms/actions/insert', $ctrl->post)){
  $ctrl->obj = $m;
}
else {
  $ctrl->action();
}
