<?php
if(!empty($ctrl->arguments[0])){
  $ctrl->addData(['id_root_alias'=> $ctrl->arguments[0]]);
}
$ctrl->action();