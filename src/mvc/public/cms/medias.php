<?php
/*
 * Describe what it does!
 *
 * @var bbn\Mvc\Controller $ctrl 
 *
 */
$notes = new \bbn\Appui\Note();
//gets all the media in notes/media/browser
$ctrl->obj->medias = $notes->get_notes_medias();