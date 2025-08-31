<?php

/** @var bbn\Mvc\Controller $ctrl */

if ( $res = $ctrl->getModel($ctrl->data['root'].'note', $ctrl->post) ){
  $ctrl->obj = \bbn\X::toObject($res);
}
else{
  $ctrl->obj->error = _("Impossible to find the note");
}