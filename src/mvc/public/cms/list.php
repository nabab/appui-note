<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->getModel($ctrl->post);
}
else{
  $ctrl->setIcon('nf nf-fa-list')
    ->combo(_("Articles' List"), [
      'types' => [
        [
          'text' => 'Post',
          'value' => $ctrl->inc->options->fromCode('post', 'types', 'note', 'appui')
        ], [
          'text' => 'Static page',
          'value' => $ctrl->inc->options->fromCode('pages', 'types', 'note', 'appui')
        ]
      ]
    ]);
  //$ctrl->combo(_("Publications"), $ctrl->getCachedModel('notes/wp_categories'));
}