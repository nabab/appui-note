<?php
use bbn\Appui\Note;
if (!empty($ctrl->get['_id'])
  && !empty($ctrl->get['_type'])
) {
  $id = $ctrl->get['_id'];
  $type = $ctrl->get['_type'];
  unset($ctrl->get['_id'], $ctrl->get['_type']);
  $noteCls = new Note($ctrl->db);
  $rendered = '';
  if (($note = $noteCls->get($id))
    && !empty($note['id_type'])
    && !empty($note['content'])
    && ($o = $ctrl->inc->options->option($type))
  ) {
    if (!empty($o['preview'])) {
      switch ($o['preview']) {
        case 'model':
          if (!empty($o['preview_model'])
            && ($m = $ctrl->getPluginModel($o['preview_model']))
            && is_callable($m['fn'])
          ) {
            $data = $m['fn']($ctrl, $ctrl->get);
            $rendered = $ctrl->render($note['content'], $data);
          }

          break;
        case 'custom':
          break;
        default:
          break;
      }
    }
  }

  echo $rendered;
}
