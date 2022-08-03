<?php
if ($m = $ctrl->getPluginModel('cms/actions/delete', $ctrl->post)) {
  $ctrl->obj = $m;
}
else{
  $ctrl->action();
}
