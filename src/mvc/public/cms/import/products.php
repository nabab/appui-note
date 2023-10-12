<?php
$opt = new \bbn\Appui\Option($ctrl->db);

if(empty($opt->fromCode('poc_product_types'))){
  //Inserts the option tags
  $opt->add([
    'text' => 'Product types',
    'code' => 'product_types',
    'items' => [[
      'text' => 'Photo',
      'code' => 'photo'
    ],[
      'text' => 'Book',
      'code' => 'book'
    ]]
  ]);
}

