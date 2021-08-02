<?php
/** @var \bbn\Mvc\Controller $ctrl */
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->getObjectModel($ctrl->post);
}
else{
  $ctrl->combo(_("Notes"), true);
}
