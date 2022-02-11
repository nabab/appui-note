<?php
if (!empty($ctrl->arguments[0])
  && \bbn\Str::isUid($ctrl->arguments[0])
) {
  $m = $ctrl->getModel([
    'id' => $ctrl->arguments[0]
  ]);
  $ctrl->addData($m['media']);
  $ctrl->combo($m['media']['title'], true);
}