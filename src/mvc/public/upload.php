<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Controller */
$fs = new \bbn\File\System();
$all = $fs->scan(BBN_DATA_PATH.'users');
$tmps = array_filter($all, function($a){
  return substr($a, -4) === '/tmp';
});
foreach ( $tmps as $tmp ){
  $fs->delete($tmp, false);
}
$all2 = $fs->scan(BBN_DATA_PATH.'users');


die(var_dump(
  $fs->dirsize(BBN_DATA_PATH.'users'),
  count($all),
  count($tmps),
  count($all2),
  $ctrl->getPlugins(),
  $ctrl->pluginPath(),
  $ctrl->pluginUrl(),
  $ctrl->pluginName(),
  $ctrl->tmpPath(),
  $ctrl->dataPath(),
  $ctrl->userTmpPath(),
  $ctrl->userDataPath(),
));
$p = [];
for ( $i = 0; $i < 10000; $i++ ){
  $path = \bbn\X::makeStoragePath(BBN_DATA_PATH.'test/logs');
  if ( \bbn\X::indexOf($p, $path) === -1 ){
    $p[] = $path;
  }
  file_put_contents($path."/test$i.txt", 'hello world');
}
die(var_dump($p));