<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->getModel($ctrl->post);
}
else{
  $ctrl->obj->bcolor = '#063B69';
  $ctrl->obj->fcolor = '#FFF';
  $ctrl->obj->icon = 'nf nf-fa-wordpress';
  $ctrl->combo(_("CMS"));
  //$ctrl->combo(_("Publications"), $ctrl->getCachedModel('notes/wp_categories'));
}