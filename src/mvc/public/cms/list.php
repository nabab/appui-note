<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->action();
}
else{
  $ctrl->setIcon('nf nf-fa-list')
    ->combo(_("Articles' List"), true);
  //$ctrl->combo(_("Publications"), $ctrl->getCachedModel('notes/wp_categories'));
}