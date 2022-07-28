<?php
$success = false;

$medias = new \bbn\Appui\Medias($model->db);
$order= ['order' => [ 'position'=> 'asc','created'=>'asc']];
$ids_group = $model->db->rselectAll('bbn_medias_groups', 'id', [] );
foreach( $ids_group as $ids ){
  $id_group = $ids['id'];
  $group = $medias->browseByGroup($id_group, $order)['data'];
  if(count($group)){
    
    $maxPosition = $model->db->selectOne('bbn_medias_groups_medias', 'position',  [
      'id_group' => $id_group,
    ], ['position'=>'desc']) ?: 0;
  
    foreach($group as $idx => $g ){
      $null = 0;
      if($g['position'] === null){
        $maxPosition += 1;
        $null += $model->db->update('bbn_medias_groups_medias', [
          'position' => $maxPosition
        ], [
          'id_group' => $id_group,
          'id_media' => $g['id']
        ]);
      }
      $group[$idx]['position'] = $maxPosition;
    }

    $same = 0;
    for ($idx = count($group) - 1; $idx >= 0; $idx--){
      if($group[$idx]['position'] !== ($idx + 1)){
        $samePosition = $model->db->rselect('bbn_medias_groups_medias', [],[
          'id_group' => $id_group,
          'position' => $idx + 1
        ]);
        if(!empty($samePosition)){
          $same ++;
          $model->db->update('bbn_medias_groups_medias', [
            'position' => null
          ], [
            'id_group' => $id_group,
            'id_media' => $samePosition['id_media']
          ]);
        }
  
        $model->db->update('bbn_medias_groups_medias', [
          'position' => $idx + 1
        ], [
          'id_group' => $id_group,
          'id_media' => $group[$idx]['id']
        ]);
  
      }
    }
  }
  
}




die(var_dump('position null = '.$null ,'reordered = '.$same ));