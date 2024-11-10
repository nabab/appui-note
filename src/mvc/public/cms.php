<?php

/** @var bbn\Mvc\Controller $ctrl */

$ctrl->setColor('#063B69', '#FFF')
  ->setIcon('nf nf-fa-wordpress')
  ->setUrl($ctrl->pluginUrl('appui-note').'/cms')
  ->addData(['root' => $ctrl->pluginUrl('appui-note').'/cms/'])
  ->combo(_("CMS"), true);
