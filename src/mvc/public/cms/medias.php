<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\Mvc\Controller 
 *
 */
$notes = new \bbn\Appui\Note();
//gets all the media in notes/media/browser
$ctrl->obj->medias = $notes->get_notes_medias();