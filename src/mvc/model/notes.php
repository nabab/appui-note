<?php
use bbn\Str;
use bbn\Appui\Note;

$notes = new Note($model->db);
return [
  'notes' => $notes->getPostIts(1000)
];
