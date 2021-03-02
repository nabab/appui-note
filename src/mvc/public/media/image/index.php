<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\Mvc\Controller
 *
 */
if ($ctrl->hasArguments()
  && ($id = $ctrl->arguments[0])
	&& ($medias = new \bbn\Appui\Medias($ctrl->db))
	&& ($media = $medias->getMedia($id, false, $ctrl->get['w'] ?? null))
) {
	$ctrl->setMode("image");
  $image = new \bbn\File\Image($media);
  $ctrl->obj->img = $image;
}