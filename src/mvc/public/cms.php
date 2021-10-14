<?php

/** @var $ctrl \bbn\Mvc\Controller */

$ctrl->setColor('#063B69', '#FFF')
  ->setIcon('nf nf-fa-wordpress')
  ->setUrl($ctrl->pluginUrl('appui-note').'/cms')
  ->combo(_("CMS"), ['root' => $ctrl->pluginUrl('appui-note').'/cms/']);
