<?php
/** @var bbn\Mvc\Controller $ctrl */

if (!empty($ctrl->files)){
	
	
	$ctrl->obj->file = $ctrl->files['file'];
	
  //die(var_dump(file_get_contents($ctrl->files['file']['tmp_name'])));
}
