<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->getModel($ctrl->post);
}
else{
  $ctrl->setIcon('nf nf-fa-list')
    ->combo(_("Articles' List"), [
      'types' => $ctrl->inc->options->textValueOptions($ctrl->inc->options->fromCode('types', 'note', 'appui'))
    ]);
  //$ctrl->combo(_("Publications"), $ctrl->getCachedModel('notes/wp_categories'));
}