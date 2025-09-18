<?php
use bbn\Appui\Note;
use bbn\X;

if (!empty($ctrl->get['hash'])
  && ($params = json_decode(base64_decode($ctrl->get['hash']), true))
  && !empty($params['_id'])
  && !empty($params['_type'])
) {
  $id = $params['_id'];
  $type = $params['_type'];
  unset($params['_id'], $params['_type']);
  $noteCls = new Note($ctrl->db);
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
            $data = $m['fn']($ctrl, $params);
          }

          break;
        case 'custom':
          $data = array_filter(
            $params,
            fn($f) => !is_null(X::find($o['preview_inputs'], ['field' => $f])),
            ARRAY_FILTER_USE_KEY
          );
          break;
        default:
          break;
      }
    }
  }

  echo $ctrl->render($note['content'], $data);
}
