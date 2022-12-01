<?php

use bbn\X;
use bbn\Str;
use bbn\File\Dir;
use bbn\Appui\Medias;
/** @var $ctrl \bbn\Mvc\Controller */

/*copy($ctrl->files['img']['tmp_name'], BBN_DATA_PATH.Str::genpwd().".png");
X::ddump(is_file($ctrl->files['img']['tmp_name']));
X::ddump($ctrl->data, $ctrl->files, $_FILES, $_POST);*/

$success = false;
if (!empty($ctrl->post['id'])
	&& !empty($ctrl->files['img']['tmp_name'])
  && !empty($ctrl->files['img']['name'])
) {
  $media = new Medias($ctrl->db);
  $tmpFile = $ctrl->files['img']['tmp_name'];
  $file = BBN_DATA_PATH.$ctrl->files['img']['name'];
  $idMedia = $ctrl->post['id'];
  Dir::copy($tmpFile, $file);
  if ($m = $media->replaceContent($idMedia, $file)) {
    $success = true;
    $oldUrl = $media->getUrl($idMedia);
    $newUrl = 'img/' . $idMedia . '/' . $m[$media->getFields()['name']];
    if ($oldUrl !== $newUrl) {
	    $success = $media->redirectUrl($idMedia, $oldUrl, $newUrl);
    }
  }
}
$ctrl->obj->success = $success;
