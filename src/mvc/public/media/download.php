<?php
use bbn\Str;
use bbn\Appui\Medias;

if ($ctrl->hasArguments()) {
	$medias = new Medias($ctrl->db);
  $url = $ctrl->getRequest();
  $idMedia = Str::isUid($ctrl->arguments[0]) ?
    $ctrl->arguments[0] :
    $medias->urlToId($url);
  if (!empty($idMedia)
    && ($media = $medias->getMedia($idMedia, true))
  ) {
    $path = $media['file'];
    if (!empty($media) && !empty($media['redirect'])) {
      header("Location: /" . dirname($url) . '/' . basename($path));
      exit();
    }

    if ($path && file_exists($path)) {
      $ctrl->setMode("file");
      $ctrl->obj->file = $path;
    }
  }
}

// 404
