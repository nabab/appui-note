<?php 
$success = true;
if ( isset($model->data['imports']) && (count($model->data['imports']) > 0) ){
  foreach($model->data['imports'] as $page){
    $model->db->change('apst_web');
    $arr = $model->db->rselect('wp_posts', ['post_content'], [ 'ID' => $page['ID'] ]);    
    $insertPage =  $model->getModel('./insert', [
      'title' => $page['post_title'],      
      'content' => $arr['post_content'],
      'start' => $page['post_date'],
      'url' => $page['url'],
      'of_import' => true 
    ]);
    if ( !$insertPage['success'] ){
      $success= false;   
      return false;
    }
  }
}
return [ 'success' => $success ];