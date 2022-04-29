<?php
if ($ctrl->hasArguments()) {
  $ctrl->addData([
    'cat' => $ctrl->arguments[0]
  ]);
  if ( !empty($ctrl->post['limit']) ){
    $ctrl->action();
  }
  elseif ($ctrl->hasArguments(3) && ($ctrl->arguments[1] === 'editor')) {
    $ctrl->addToObj($ctrl->pluginUrl('appui-note') . '/cms/editor/' . $ctrl->arguments[2]);
    $ctrl->setUrl($ctrl->pluginUrl('appui-note') . '/cms/cat/' . $ctrl->arguments[0] . '/editor/' . $ctrl->arguments[2]);
  }
  else{
    $ctrl->setIcon('nf nf-fa-list')
      ->combo(_("Articles' List"), true);
    //$ctrl->combo(_("Publications"), $ctrl->getCachedModel('notes/wp_categories'));
  }
}
