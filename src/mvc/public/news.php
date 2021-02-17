<?php
/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 15:36
 *
 * @var $ctrl \bbn\Mvc\Controller
 */

$ctrl->obj->icon = 'nf nf-fa-rss_square';
$ctrl->combo(_('News'), [
  'root' => APPUI_NOTE_ROOT,
  'type' => $ctrl->inc->options->fromCode('news', 'types', 'note', 'appui')
]);