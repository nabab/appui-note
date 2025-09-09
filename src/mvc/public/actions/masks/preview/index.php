<?php
use bbn\Appui\Note;
die(var_dump($ctrl->arguments));
if (!empty($ctrl->arguments['id'])) {
  $id = $ctrl->arguments['id'];
  $noteCls = new Note($ctrl->db);
  if ($note = $noteCls->get($id)) {
    die(var_dump($note));
  }
}
