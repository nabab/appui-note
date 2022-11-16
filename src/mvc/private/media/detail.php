<?php

use bbn\X;

if (!empty($ctrl->arguments[0])
  && \bbn\Str::isUid($ctrl->arguments[0])
) {
  $ctrl->addData([
    'id' => $ctrl->arguments[0]
  ])->combo('$title', true);
}