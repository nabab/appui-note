<?php

use bbn\X;
use bbn\Str;
/** @var $ctrl \bbn\Mvc\Controller */

if ($ctrl->hasData('root')) {
  if (empty(BBN_BASEURL)) {
    $ctrl->setUrl($ctrl->data['root'].'media')
      ->setColor('#ccffcc', '#009688')
      ->setIcon('nf nf-mdi-folder_multiple_image')
      ->combo(_("Medias"));
  }
  else {
    $req = $ctrl->hasArguments() ? X::join($ctrl->arguments, '/') : 'browser';
    $ctrl->addToObj($ctrl->data['root'].'media/'.$req, $ctrl->data, true);
  }
}
