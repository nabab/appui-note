<?php

use bbn\X;
use bbn\Str;
/** @var bbn\Mvc\Controller $ctrl */

if (($ctrl->getConstant('baseURL') !== null) && $ctrl->hasData('root')) {
  if (empty($ctrl->getConstant('baseURL'))) {
    $ctrl->setUrl($ctrl->data['root'].'media')
      ->setColor('#ccffcc', '#009688')
      ->setIcon('nf nf-md-folder_multiple_image')
      ->combo(_("Medias"));
  }
  else {
    $req = $ctrl->hasArguments() ? X::join($ctrl->arguments, '/') : 'browser';
    $ctrl->addToObj($ctrl->data['root'].'media/'.$req, $ctrl->data, true);
  }
}
