<?php

/** @var $ctrl \bbn\Mvc\Controller */

use bbn\X;

$html = file_get_contents(BBN_DATA_PATH."bookmarks.html");

$dom = new DOMDocument();
$dom->loadHTML($html);
$res = [];

foreach($dom->getElementsByTagName("a") as $a) {
	var_dump($a->getNodePath());
  if ($a->parentNode) {
		$res[] = 'test';
  }
  else {
    $res[] = $a['nodeValue'];
  }
}
var_dump($res);