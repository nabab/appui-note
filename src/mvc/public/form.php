<?php
$ctrl->setIcon('nf nf-fa-pencil')
  ->combo(_('Notes Form'), [
    'types' => $ctrl->inc->options->textValueOptions($ctrl->inc->options->fromCode('types', 'note', 'appui')),
    'languages' => $ctrl->inc->options->codeOptions('languages', 'core', 'appui')
  ]);