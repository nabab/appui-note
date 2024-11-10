<?php

use bbn\X;
use bbn\Str;
/** @var bbn\Mvc\Controller $ctrl */

if (!empty($ctrl->arguments[0])
  && \bbn\Str::isUid($ctrl->arguments[0])
) {
  $ctrl->addData([
    'id' => $ctrl->arguments[0]
  ])->setUrl(APPUI_NOTE_ROOT.'media/editor')->combo('$title', true);
}
