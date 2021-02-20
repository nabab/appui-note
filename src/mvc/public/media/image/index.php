<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\Mvc\Controller
 *
 */


use bbn\X;

if ($ctrl->hasArguments()) {
	$ctrl->setMode("image");
	$medias = new \bbn\Appui\Medias($ctrl->db);
	if (empty($ctrl->arguments[1])) {
		//case of previews in block, I want the thumbnails 60 x 60
    $med = $medias->getMedia($ctrl->arguments[0], true);
    /** @todo For Lore BS! */
    if (strtolower(substr($med['file'], - strlen($med['extension']))) !== $med['extension']) {
      $med['file'] .= ".$med[extension]";
    }
		$img = $medias->getThumbs($med['file'], [250, false]);
	}
	else{
    $med = $medias->getMedia($ctrl->arguments[0], true);
    /** @todo For Lore BS! */
    if (strtolower(substr($med['file'], - strlen($med['extension']))) !== $med['extension']) {
      $med['file'] .= ".$med[extension]";
    }
		//case of showing full picture
		$img = $med['file'];
	}

  $image = new \bbn\File\Image($img);
  $ctrl->obj->img = $image;
}


