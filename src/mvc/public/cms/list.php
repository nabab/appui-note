<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->getModel($ctrl->post);
}
else{
  $ctrl->setIcon('nf nf-fa-list')
    ->combo(_("Articles' List"));
  //$ctrl->combo(_("Publications"), $ctrl->getCachedModel('notes/wp_categories'));
}