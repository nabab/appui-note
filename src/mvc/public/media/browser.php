<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->action();
}
else{
  $ctrl->obj->fcolor= '#009688';
  $ctrl->obj->bcolor = '#ccffcc';
	$ctrl->obj->icon = 'nf nf-oct-file_media';
  $ctrl->combo(_('Medias browser'), ['root' => APPUI_NOTE_ROOT]);
}