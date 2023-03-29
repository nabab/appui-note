<?php
use bbn\X;
use bbn\Str;
use bbn\File\System;
use bbn\Appui\Medias;

if ($ctrl->hasArguments()) {
	$medias = new Medias($ctrl->db);
	$path = '';
  $url = $ctrl->getRequest();
  $realUrl = $url;
  $reg = '/\.bbn-([\-\dwhc]+)\./';
  $width = $ctrl->get['w'] ?? null;
  $height = $ctrl->get['h'] ?? null;
  $crop = $ctrl->get['c'] ?? false;
  preg_match($reg, $url, $match);
  if (!empty($match[1])) {
    $ext1 = Str::fileExt($url, true);
    $ext2 = Str::fileExt($ext1[0], true);
    $realUrl = dirname($url) . '/' . $ext2[0] . '.' . $ext1[1];
    $rules = X::split($ext2[1], '-');
    array_shift($rules);
    $is = null;
    foreach ($rules as $r) {
      switch ($r) {
        case 'w':
          $is = 'width';
          break;
        case 'h':
          $is = 'height';
          break;
        case 'c':
          $is = 'crop';
          break;
        default:
          if ($is) {
            $$is = ($is === 'crop') ? true : ($r ?: false);
          }
          break;
      }
    }
  }

  $idMediaFromUrl = false;
  $media = false;

  if (Str::isUid($ctrl->arguments[0])
    && ($media = $medias->getMedia($ctrl->arguments[0], true, $width, $height, $crop, true))
  ) {

		$path = $media['file'];
  }
  elseif ($idMediaFromUrl = $medias->urlToId($realUrl)) {
    $media = $medias->getMedia($idMediaFromUrl, true, $width, $height, $crop);
    $path = $media['file'];
  }

  if (!empty($media) && !empty($media['redirect'])) {
    header("Location: /" . dirname($url) . '/' . basename($media['file']));
    exit();
  }

  if ($path && file_exists($path)) {
    if ($idMediaFromUrl) {
      $fs = new System();
      $fs->createPath(dirname(BBN_PUBLIC . $url));
      symlink(is_link($path) ? readlink($path) : $path, BBN_PUBLIC . $url);
    }

    $ctrl->setMode("image");
    $ctrl->obj->img = $path;
	}
}

// 404
