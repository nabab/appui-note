<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->getModel($ctrl->post);
}
else{
  $ctrl->obj->bcolor = '#E600BF';
  $ctrl->obj->fcolor = '#FFF';
  $ctrl->obj->icon = 'nf nf-fa-newspaper_o';
  $ctrl->combo(_("CMS"), true);
  //$ctrl->combo(_("Publications"), $ctrl->getCachedModel('notes/wp_categories'));
}