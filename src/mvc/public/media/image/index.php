<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\Mvc\Controller
 *
 */



if (  $ctrl->arguments[0] ){
	$ctrl->setMode("image");
	$medias = new \bbn\Appui\Medias($ctrl->db);
	if ( empty($ctrl->arguments[1]) ){
		//case of previews in block, I want the thumbnails 60 x 60
		$img = $medias->getThumbs($medias->getMediaPath($ctrl->arguments[0]));
	}
	else{
		//case of showing full picture
		$img = $medias->getMediaPath($ctrl->arguments[0]);
	}
	$image= new \bbn\File\Image($img);
	die(var_dump($image->display()));
}


