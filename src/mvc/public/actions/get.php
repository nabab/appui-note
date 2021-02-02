<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Controller */

if ( $res = $ctrl->getModel($ctrl->data['root'].'note', $ctrl->post) ){
  $ctrl->obj = \bbn\X::toObject($res);
}
else{
  $ctrl->obj->error = _("Impossible to find the note");
}