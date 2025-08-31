<?php
/** @var bbn\Mvc\Controller $ctrl */
if ( !empty($ctrl->post) ){
  $ctrl->obj = $ctrl->getObjectModel($ctrl->post);
}
else{
  $ctrl->combo(_("Notes"), true);
}
