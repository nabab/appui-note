<?php

/** @var $ctrl \bbn\Mvc\Controller */

$path = $ctrl->contentPath().'articles/';
$fs = new bbn\File\System();
$files = $fs->getFiles($path, false, false, 'html');
$res = [];
$ids = [];

$chrono = new bbn\Util\Timer();
$old_url = 'https://images.squarespace-cdn.com';
$old_url2 = 'http://static1.squarespace.com';

if ( count($files) ){
  foreach ( $files as $i => $f ) {
     $st = $fs->getContents($f);
     $dom = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<root>'.$st.'</root>');
      $res[$f] = [];
    die(var_dump($dom->link));
      if ((string)$dom->link !== '/home') {
        continue;
      }
          $res[$f]['title'] = (string)($dom->title ?? '');
          $res[$f]['name'] = (string)($dom->{'wp:post_name'} ?? '');
          $res[$f]['type'] = (string)($dom->{'wp:post_type'} ?? '');
          $res[$f]['id'] = (string)($dom->{'wp:post_id'} ?? '');
          $res[$f]['url'] = (string)($dom->link ?? '');
          $res[$f]['author'] = (string) $dom->{'dc:creator'} ?? '';
          $res[$f]['parent'] = (!empty((string) $dom->{'wp:post_parent'}) || ((string) $dom->{'wp:post_parent'} === 0) ) ? (string) $dom->{'wp:post_parent'} : null;
          $res[$f]['excerpt'] = (string)$dom->{'excerpt:encoded'} ?? '';
          $res[$f]['attachment'] = (string) $dom->{'wp:attachment_url'} ?? '';
          $res[$f]['status'] = (string)($dom->{'wp:status'} ?? '');
          $res[$f]['pubDate'] = (string)($dom->pubDate ?? '');
          if ($res[$f]['pubDate']) {
            $res[$f]['pubDate'] = date('Y-m-d H:i:s', strtotime($res[$f]['pubDate']));
          }
          $res[$f]['postDate'] = (string)($dom->{'wp:post_date'} ?? '');
          $res[$f]['postDateGMT'] = (string)($dom->{'wp:post_date_gmt'} ?? '');
    
     if (
      ((string)$dom->{'wp:post_type'} === 'post') &&
      isset($dom->{'wp:postmeta'}->{'wp:meta_value'})
    ){
      $meta_value = (string)$dom->{'wp:postmeta'}->{'wp:meta_value'}; 
      $ids[$meta_value] = (string) $dom->{'wp:post_id'};
    }
$res[$f]['comments'] = [];
    if ( $dom->{'wp:comment'} ){
      foreach ( $dom->{'wp:comment'}  as $d ){
        $res[$f]['comments'][] = [
          //remember to make the uid in db
          'id' => (string) $d->{'wp:comment_id'},
          'approved' => (string) $d->{'wp:comment_approved'},
          'author'=> (string) $d->{'wp:comment_author'},
          'author_email'=> (string) $d->{'wp:comment_author_email'},
          'author_url'=> (string) $d->{'wp:author_url'},
          'author_IP'=> (string) $d->{'wp:comment_author_IP'},
          'date' => (string) $d->{'wp:comment_date'},
          'date_gmt' => (string) $d->{'wp:comment_date_gmt'},
          'content' => (string) $d->{'wp:comment_content'},
          'type' => (string) $d->{'wp:comment_type'},
          'comment_parent'=> (string) $d->{'wp:comment_parent'},
        ];
      }
    }
    $res[$f]['comment_status'] = (string) $dom->{'wp:comment_status'} ?? null;
    
     $res[$f]['categories'] = [];
    $res[$f]['tags'] = [];
  }
}