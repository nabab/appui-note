<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Controller */
if ( isset($ctrl->arguments[0]) ){
  $res = $ctrl->getModel('./../note', ['id_note' => $ctrl->arguments[0]]);
  if ( $res['success'] && !empty($res['note']) ){
    echo $ctrl->getView('./../note/note', $res['note']);
  }
}
