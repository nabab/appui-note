<?php
/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 08/02/17
 * Time: 11.06
 *
 * @var $ctrl \bbn\Mvc\Controller
 */
$ctrl->data = \bbn\X::mergeArrays($ctrl->data, $ctrl->post);

$ctrl->obj->data = $ctrl->getModel('./prove_notes', $ctrl->data);