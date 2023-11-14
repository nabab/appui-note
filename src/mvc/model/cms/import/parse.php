<?php
use bbn\X;
use bbn\File\System;
use bbn\Util\Timer;
/*

  [ "", "MarineCabos-Brullé", "marinecabos@yahoo.fr", ]

  Analyzes the xml files contained in the folder
  articles and creates foreach html file a json file corresponding to
  the row of the table articles in db.
  */
$fs = new System();
if (defined('APPUI_NOTE_CMS_IMPORT_PATH')) {
  if ($model->data['action'] == 'undo') {
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'ids.json');
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'categories.json');
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'tags.json');
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'medias.json');
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'posts_medias.json');
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'json', true);
    return [
      'success' => true,
      'message' => X::_('Process undo successfully.')
    ];
  }
  else {
    $num_inserted = 0;
    if ($fs->exists(APPUI_NOTE_CMS_IMPORT_PATH.'json')) {
      $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'json', true);
    }

    $fs->createPath(APPUI_NOTE_CMS_IMPORT_PATH.'json');
    $cfgFile = APPUI_NOTE_CMS_IMPORT_PATH.'cfg.json';
    if (is_file($cfgFile)
      && ($cfg = $fs->getContents($cfgFile))
      && ($cfg = json_decode($cfg, true))
      && !empty($cfg['baseUrl'])
    ) {
      $baseUrl = $cfg['baseUrl'];
    }

    if (empty($baseUrl)) {
      throw new \Exception(_("No baseUrl"));
    }

    $path = APPUI_NOTE_CMS_IMPORT_PATH.'xml/';
    $files = $fs->getFiles($path, false, false, 'xml');
    $res = [];
    $ids = [];
    $categories = [];
    $tags = [];
    $azerty = 0;
    $chrono = new Timer();
    $mediaRegex = '/'.preg_quote($baseUrl, '/').'\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/(.*)/';
    $medias = [];
    $mediasPosts = [];
    $getMediaSrc = function($src, $id) use($mediaRegex, &$mediasPosts, &$medias, $baseUrl){
      preg_match($mediaRegex, $src, $mediaMatches);
      if (!empty($mediaMatches[1])) {
        if (!in_array($src, $medias)) {
          $medias[] = $src;
        }

        if (!isset($mediasPosts[$id])) {
          $mediasPosts[$id] = [];
        }

        if (!in_array($src, $mediasPosts[$id])) {
          $mediasPosts[$id][] = $src;
        }

        if (str_starts_with($src, $baseUrl)) {
          $src = substr($src, strlen($baseUrl));
          if (strpos($src, '/') === 0) {
            $src = substr($src, 1);
          }
        }
      }

      return $src;
    };

    //$files = ['/home/thomas/domains/poc3.thomas.lan/app-ui/data/content/articles/marine-00997.html'];
    // check if $file is not null (When the parameter is neither an array nor an object with implemented Countable interface, 1 will be returned. There is one exception, if value is null, 0 will be returned.)
    if ( count($files) ){
      // make string array with data for each file
      foreach ( $files as $i => $f ) {
        //if ($f === '/home/thomas/domains/poc.thomas.lan/app-ui/data/content/articles/marine-00002.html'){    $srcs = [];
        $st = $fs->getContents($f);
        $dom = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<root>'.$st.'</root>', null, LIBXML_NOERROR);
        $res[$f] = [];
        /*
          if ((string)$dom->link !== '/home') {
            continue;
          }
          */

        //per il blocco immagine registrare in db contenuto del tag figcaption se esiste, il tag a volte ha dentro un link.. meglio registrare come html
        //x il contenuto del blocco html si possono togliere stili e classi dagli elementi
        //X THOMAS, QUANDO VIENE IMPORTATO IL CONTENUTO HTML DELL'ARTICOLO SE UN (div.sqs-row) ha querySelectorAll('hr').length AGGIUNGI LA CLASSE has-hr al contenitore

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
        // if global file have pubDate attribute
        if ($res[$f]['pubDate']) {
          $res[$f]['pubDate'] = date('Y-m-d H:i:s', strtotime($res[$f]['pubDate']));
        }
        $res[$f]['postDate'] = (string)($dom->{'wp:post_date'} ?? '');
        $res[$f]['postDateGMT'] = (string)($dom->{'wp:post_date_gmt'} ?? '');
        // if global file wp:post_type attribute equal to "post" and wp:postmeta->wp:metavalue is not null
        if ((((string)$dom->{'wp:post_type'} === 'post')
            || ((string)$dom->{'wp:post_type'} === 'page'))
          && isset($dom->{'wp:postmeta'}->{'wp:meta_value'})
        ) {
          // set a meta_value in ids array with wp:post_id of global file
          $meta_value = (string)$dom->{'wp:postmeta'}->{'wp:meta_value'};
          $ids[$meta_value] = (string) $dom->{'wp:post_id'};
        }
        // if in global file attribute "wp:comment" is found, we put all the comment attribute in an array of comments
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
        if (!empty($dom->category)) {
          foreach ($dom->category as $c) {
            $attr = $c->attributes();
            foreach ($attr as $att) {
              if ( $att->getName() === 'domain' ){
                if ((string)$attr === 'post_tag' ){
                  $nicename = (string)$attr->nicename;
                  $tags[$nicename] = (string) $c;
                  $res[$f]['tags'][] = [
                    'code' => $nicename,
                    'value' => (string) $c
                  ];
                }
                else if ( (string)$attr === 'category' ){
                  $nicename = (string)$attr->nicename;
                  $res[$f]['categories'][] = [
                    'code' => $nicename,
                    'value' => (string) $c
                  ];
                  if (count($res[$f]['categories']) === 1) {
                    $categories[$nicename] = (string) $c;
                  }
                }
              }
            }
          }
        }

        if (!empty($dom->{'content:encoded'})) {
          $blocks = [];
          $st = (string)$dom->{'content:encoded'};
          $dom2 = new \DOMDocument();
          $dom2->loadHTML('<?xml encoding="UTF-8"?>'.$st, LIBXML_NOERROR);
          $body = $dom2->getElementsByTagName('body')[0];
          foreach ($body->childNodes as $childnodeIdx => $c) {
            $tmp = [];
            if (($c->nodeType === XML_TEXT_NODE)
              && !empty($c->textContent)
            ) {
              //$textContent = trim(str_replace(PHP_EOL, '', $c->textContent));
              $textContent = trim($c->textContent);
              if (!empty($textContent)) {
                $tmp['type'] = 'text';
                $tmp['content'] = $textContent;
              }
            }
            else if ($c->nodeType === XML_ELEMENT_NODE) {
              // Get alt attribute
              if ($c->getAttribute('alt')) {
                $tmp['alt'] = $c->getAttribute('alt');
              }

              // Get style attribute
              if ($c->hasAttribute('style')) {
                $tmpStyle =  explode(';', $c->getAttribute('style'));
                if (!empty($tmpStyle)) {
                  $tmp['style'] = [];
                  foreach ($tmpStyle as $t) {
                    if (!empty($t)) {
                      $tmp['style'][explode(':', $t)[0]] = explode(':', $t)[1];
                    }
                  }
                }
              }

              //Goes in all blocks to create the array of bbn configuration and the bbn html tag
              switch($c->tagName) {
                  // BLOCK TITLE
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6':
                  if (!empty($c->childNodes)) {
                    $tmp['type'] = 'html';
                    $tmp['content'] = str_replace(PHP_EOL, '<br>', $dom2->saveHTML($c));
                    if ($otherImg = $c->getElementsByTagName('img')) {
                      foreach ($otherImg as $o) {
                        if ($o->getAttribute('src')) {
                          $tmpSrc = $o->getAttribute('src');
                        }
                        else if ($o->getAttribute('data-src')) {
                          $tmpSrc = $o->getAttribute('data-src');
                        }
                        $getMediaSrc($tmpSrc, $res[$f]['id']);
                      }
                    }
                    break;
                  }
                  $tmp['tag'] = $c->tagName;
                  $tmp['type'] = 'title';
                  $tmp['content'] = str_replace(PHP_EOL, '<br>', $c->textContent);
                  $tmp['hr'] = null;
                  $tmp['align'] = !empty($tmp['style']['text-align']) ? $tmp['style']['text-align'] : 'left';
                  break;
  
                  //BLOCK LINE
                case 'hr':
                  $tmp['type'] = 'line';
                  $tmp['hr'] = 'top';
                  $tmp['width'] = '100%';
                  break;
  
                case 'img':
                  $tmp['type'] = 'image';
                  $tmp['width'] = !empty($c->getAttribute('width')) ?
                    $c->getAttribute('width').'px' :
                    (isset($tmp['style']['width']) ? $tmp['style']['width'] : 'auto');
                  $tmp['height'] = !empty($c->getAttribute('height')) ?
                    $c->getAttribute('height').'px' :
                    (isset($tmp['style']['width']) ? $tmp['style']['height'] : 'auto');
                  if ($c->getAttribute('src')) {
                    $tmp['content'] = $c->getAttribute('src');
                  }
                  else if ($c->getAttribute('data-src')) {
                    $tmp['content'] = $c->getAttribute('data-src');
                  }
                  $tmp['content'] = $getMediaSrc($tmp['content'], $res[$f]['id']);
                  $tmpClasses = $c->getAttribute('class');
                  $tmp['align'] = 'left';
                  if (!empty($tmpClasses)) {
                    $tmpClasses = explode(' ', $tmpClasses);
                    if (in_array('aligncenter', $tmpClasses)) {
                      $tmp['align'] = 'center';
                    }
                    if (in_array('alignright', $tmpClasses)) {
                      $tmp['align'] = 'right';
                    }
                  }
                  break;
  
                case 'video':
                  $tmpClasses = $c->getAttribute('class');
                  $tmp['type'] = 'video';
                  $tmp['width'] = !empty($c->getAttribute('width')) ?
                    $c->getAttribute('width').'px' :
                    (isset($tmp['style']['width']) ? $tmp['style']['width'] : 'auto');
                  $tmp['height'] = !empty($c->getAttribute('height')) ?
                    $c->getAttribute('height').'px' :
                    (isset($tmp['style']['width']) ? $tmp['style']['height'] : 'auto');
                  if ($c->getAttribute('src')) {
                    $tmp['content'] = $c->getAttribute('src');
                  }
                  else if ($c->getAttribute('data-src')) {
                    $tmp['content'] = $c->getAttribute('data-src');
                  }
                  $tmp['content'] = $getMediaSrc($tmp['content'], $res[$f]['id']);
                  $tmp['scrolling'] = $c->getAttribute('scrolling') ?: '';
                  $tmp['frameborder'] = $c->getAttribute('frameborder') ?: '';
                  $tmp['allowfullscreen'] = $c->getAttribute('allowfullscreen') ?: '';
                  $tmpClasses = $c->getAttribute('class');
                  $tmp['align'] = 'left';
                  if (!empty($tmpClasses)) {
                    $tmpClasses = explode(' ', $tmpClasses);
                    if (in_array('aligncenter', $tmpClasses)) {
                      $tmp['align'] = 'center';
                    }
                    if (in_array('alignright', $tmpClasses)) {
                      $tmp['align'] = 'right';
                    }
                  }
                  break;
  
                case 'button':
                  if (!empty($c->childNodes)) {
                    $tmp['type'] = 'html';
                    $tmp['content'] = str_replace(PHP_EOL, '<br>', $dom2->saveHTML($c));
                    if ($otherImg = $c->getElementsByTagName('img')) {
                      foreach ($otherImg as $o) {
                        if ($o->getAttribute('src')) {
                          $tmpSrc = $o->getAttribute('src');
                        }
                        else if ($o->getAttribute('data-src')) {
                          $tmpSrc = $o->getAttribute('data-src');
                        }
                        $getMediaSrc($tmpSrc, $res[$f]['id']);
                      }
                    }
                    break;
                  }
                  $tmp['type'] = 'button';
                  $tmp['content'] = $c->innerHTML;
                  $tmp['align'] = !empty($tmp['style']['text-align']) ? $tmp['style']['text-align'] : 'left';
                  break;
  
                default:
                  $tmp['type'] = 'html';
                  $tmp['content'] = str_replace(PHP_EOL, '<br>', $dom2->saveHTML($c));
                  if ($otherImg = $c->getElementsByTagName('img')) {
                    foreach ($otherImg as $o) {
                      if ($o->getAttribute('src')) {
                        $tmpSrc = $o->getAttribute('src');
                      }
                      else if ($o->getAttribute('data-src')) {
                        $tmpSrc = $o->getAttribute('data-src');
                      }
                      $getMediaSrc($tmpSrc, $res[$f]['id']);
                    }
                  }
                  break;
              }

              if (isset($tmp['style']['text-align']) && !empty($tmp['align'])) {
                unset($tmp['style']['text-align']);
              }

              if (array_key_exists('style', $tmp) && empty($tmp['style'])) {
                unset($tmp['style']);
              }
            }

            $blocks[] = $tmp;
          }

          //remove empty index from blocks
          $last_blocks = [];
          //CREATES the tag of the component to insert in db for each block
          $all_tag = '';
          //die(X::dump($blocks));

          foreach ($blocks as $block) {
            if (!empty($block) && !empty($block['type'])) {
              $bbn_tag = '<bbn-cms-block';
              foreach ($block as $key => $val) {
                $bbn_tag .= ' ';
                if (!is_string($val)) {
                  $bbn_tag .= ':';
                }
                $bbn_tag .= $key.'="'.(is_array($val) ? json_encode($val) : $val).'"';
              }
              $bbn_tag .= '></bbn-cms-block>';
              $all_tag .= $bbn_tag;
              if (!empty($block['type'])) {
                $last_blocks[] = $block;
              }


            }
          }
        }
        else{
          continue;
        }

        $res[$f]['bbn_elements'] = $all_tag;
        $res[$f]['bbn_cfg'] = $last_blocks;

        $res[$f]['content'] = (string)($dom->{'content:encoded'} ?? '');
        $json_file = pathinfo($f)['filename'] . '.json';
        if ($fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'json/'.$json_file, json_encode($res[$f], JSON_UNESCAPED_UNICODE))) {
          $num_inserted++;
        }
        $res[$f] = null;
        $dom = null;
      }

      //}
      $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'ids.json', json_encode($ids, JSON_PRETTY_PRINT));
      $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'categories.json', json_encode($categories, JSON_PRETTY_PRINT));
      $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'tags.json', json_encode($tags, JSON_PRETTY_PRINT));
      $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'medias.json', json_encode($medias, JSON_PRETTY_PRINT));
      $fs->putContents(APPUI_NOTE_CMS_IMPORT_PATH.'posts_medias.json', json_encode($mediasPosts, JSON_PRETTY_PRINT));
    }

    return [
      'success' => true,
      'message' => X::_("Process launch successfully, %d JSON files created.", $num_inserted)
    ];
  }
}
