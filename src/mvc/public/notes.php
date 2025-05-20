<?php
use bbn\X;

/** @var \bbn\Mvc\Controller $ctrl */
if ($ctrl->hasArguments()) {
  $ctrl->addData(['data' => true])->action();
}
else {
  $ctrl->combo(_("My post-it"), true);
}
/*
$note = new bbn\Appui\Note($ctrl->db);
X::hdump($note->setPostIt(['content' => 'Hello world', 'title' => 'My first post-it', 'color' => '#FBAE3C']));
*/
