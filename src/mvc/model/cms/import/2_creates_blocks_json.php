<?php
use bbn\X;
/*

  [ "", "MarineCabos-Brullé", "marinecabos@yahoo.fr", ]

  Analyzes the xml files contained in the folder
  articles and creates foreach html file a json file corresponding to
  the row of the table articles in db.
  */
$fs = new bbn\File\System();
if (defined('APPUI_NOTE_CMS_IMPORT_PATH')) {
  if ($model->data['action'] == 'undo') {
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'blocks', true);
    $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'medias', true);
    return ['message' => 'Process undo successfully.'];
  }
  else {
    $num_inserted = 0;
    if ($fs->exists(APPUI_NOTE_CMS_IMPORT_PATH.'blocks')) {
      $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'blocks', true);
    }
    if ($fs->exists(APPUI_NOTE_CMS_IMPORT_PATH.'medias')) {
      $fs->delete(APPUI_NOTE_CMS_IMPORT_PATH.'medias', true);
    }
    $fs->createPath(APPUI_NOTE_CMS_IMPORT_PATH.'blocks');
    $fs->createPath(APPUI_NOTE_CMS_IMPORT_PATH.'medias');
    $path = APPUI_NOTE_CMS_IMPORT_PATH.'items/';

    $files = $fs->getFiles($path, false, false, 'xml');
    $res = [];
    $ids = [];

    $categories = [
      'cats' => [],
      'tags' => []
    ];

    $failedTag = [];
    $azerty = 0;
    $chrono = new bbn\Util\Timer();
    $mediaRegex = '/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/(.*)/';
    $medias = [];

    //$files = ['/home/thomas/domains/poc3.thomas.lan/app-ui/data/content/articles/marine-00997.html'];
    // check if $file is not null (When the parameter is neither an array nor an object with implemented Countable interface, 1 will be returned. There is one exception, if value is null, 0 will be returned.)
    if ( count($files) ){
      // make string array with data for each file
      foreach ( $files as $i => $f ) {
        //if ($f === '/home/thomas/domains/poc.thomas.lan/app-ui/data/content/articles/marine-00002.html'){    $srcs = [];
        $st = $fs->getContents($f);
        $dom = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<root>'.$st.'</root>');
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
        if (
          ((string)$dom->{'wp:post_type'} === 'post') &&
          isset($dom->{'wp:postmeta'}->{'wp:meta_value'})
        ){
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
                  $categories['tags'][$nicename] = (string) $c;
                  $res[$f]['tags'][] = [
                    'code' => $nicename,
                    'value' => (string) $c
                  ];
                }
                else if ( (string)$attr === 'category' ){
                  $nicename = (string)$attr->nicename;
                  $categories['cats'][$nicename] = (string) $c;
                  $res[$f]['categories'][] = [
                    'code' => $nicename,
                    'value' => (string) $c
                  ];
                }
              }
            }
          }
        }
        $res[$f]['photographer'] = ((string)$dom->{'wp:post_type'} === 'page') ? (string) $dom->title : '';
        if ( !empty($dom->{'content:encoded'} ) ){

          $blocks = [];
          $st = (string)$dom->{'content:encoded'};
          $dom2 = new \DOMDocument();
          $dom2->loadHTML('<?xml encoding="UTF-8"?>'.$st);
          $body = $dom2->getElementsByTagName('body')[0];
          foreach ( $body->childNodes as $childnodeIdx => $c ) {

            if ( $c->tagName ){
              $tmp = [];
              $tmp['node'] = $c;
              //@todo controllare attribute alt e in caso inserirlo nel tag
              //Goes in all blocks to create the array of bbn configuration and the bbn html tag
              switch($c->tagName) {
                  // BLOCK TITLE
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6':
                  $tmp['tag'] = $c->tagName;
                  $tmp['type'] = 'title';
                  $tmp['content'] = $c->textContent;

                  $tmp['hr'] = false;

                  break;

                  //BLOCK LINE
                case 'hr':
                  $tmp['type'] = 'line';
                  //$tmp['style']['width'] = '100%';
                  break;

                  //BLOCK HTML
                  //IMPORTANT TAKE THE CONTENT OF STRONG, SUCH AS MORE INFORMATION: IN FILE 00005
                case 'p':
                case 'span':
                  //messo dentro ilblock html <a> non so se mi sbaglio
                case 'a':
                  //@todo controllare se i caratteri cinesi vengono convertiti, sono nel file marine-00003.html
                  $href = '';
                  $content = '';
                  $contents = [];

                  if ( ( $c->tagName === 'p' ) ){
                    if ( !empty($c->childNodes) ){
                      foreach($c->childNodes as $i => $child){
                        //case of p containing only text
                        $text = '';

                        if( !empty($child->textContent) ) {
                          if ( $child->tagName === 'strong' ) {
                            $contents[] = '<strong>'.$child->textContent.'</strong><br>';
                          }
                          else {
                            $contents[] = $child->textContent;
                          }
                        }
                        //case of p containing <a
                        else if ( !empty($child->tagName) && ($c->parentNode->tagName !== 'body') && ($child->tagName === 'a') ){
                          $contents[] = '<a '. ( !empty($child->getAttribute('href')) ? ('href="'.$child->getAttribute('href').'"') : '' ) .'>'.$child->textContent.'</a>';
                        }
                      }
                    }
                    if ( !empty($contents) ){
                      $content .= '<' . $c->tagName.'>';
                      $content .= implode($contents);
                      $content .=  '</'.  $c->tagName . '>';
                      $tmp['content'] = $content;
                      $tmp['type'] = 'html';
                    }
                  }
                  if ( $c->tagName === 'a' ){
                    $content .= '<a';
                    if ( $c->hasAttribute('href') ){
                      $content  .= ' href="'.$c->getAttribute('href').'"';
                    }
                    if ( !empty($c->childNodes) ){
                      foreach($c->childNodes as $child){
                        //case of p containing only text
                        $text = '';
                        if ( empty($child->tagName) && !empty($child->wholeText) ){
                          $contents[] = $child->wholeText;
                        }

                        //case of p containing <a
                        else if ( !empty($child->tagName) && ($child->tagName === 'a') ){
                          $contents[] = '<'.$child->tagName . ( !empty($child->getAttribute('href')) ? ('href="'.$child->getAttribute('href').'"') : '' ) .'>'.$child->textContent.'</'.$child->tagName.'>';
                        }
                      }
                    }

                    if ( !empty($contents) ){
                      $content .= '>'.implode($contents);
                    }
                    $content .=  '</'.  $c->tagName . '>';
                    $tmp['content'] = $content;
                  }
                  break;
                  //CASE VIDEO
                case 'iframe':
                  if ( $tmp['src'] = $c->getAttribute('src') ){
                    if(strpos($tmp['src'], '//') === 0){
                      $tmp['src'] = 'https:'.$tmp['src'];
                    }

                    $tmp['type'] = 'video';
                    $tmp['height'] = $c->getAttribute('height') ?: '';
                    $tmp['width'] = $c->getAttribute('width') ?: '';
                    $tmp['scrolling'] = $c->getAttribute('scrolling') ?: '';
                    $tmp['frameborder'] = $c->getAttribute('frameborder') ?: '';
                    $tmp['allowfullscreen'] = $c->getAttribute('allowfullscreen') ?: '';
                  }
                  break;
                case 'div':
                  //CASE GALLERY
                  // trim($a) is the key of div class
                  $attr_class = array_map(function($a){
                    if ( !empty($a) ){
                      return trim($a);
                    }
                  },explode(' ',$c->getAttribute('class')));

                  //$c->getAttribute('class') --- case of div without class containing a gallery of images
                  if ( (!empty($attr_class) && in_array('sqs-gallery-container', $attr_class) ) || empty($c->getAttribute('class')) ){
                    $tmp['type'] = 'gallery';
                    $images = [];

                    foreach ($c->childNodes as $child) {
                      if ( $child->tagName && ($child->tagName === 'div')) {
                        $child_classes =  explode(' ', $child->getAttribute('class'));
                        if (in_array('sqs-gallery', $child_classes) && !empty($child->childNodes)) {
                          foreach ($child->childNodes as $slide) {
                            if ($slide->tagName && ($slide->tagName === 'div')){
                              $classes = explode(' ',$slide->getAttribute('class'));
                              if (in_array('slide', $classes) && !empty($slide->childNodes)) {
                                if (($img = $slide->getElementsByTagName('img'))
                                  && ($tmp_src = $img[0]->getAttribute('src'))
                                ) {
                                  $tmp2 = [];
                                  $img = $img[0];
                                  if ($link = $slide->getElementsByTagName('a')[0]){
                                    //if the domain in href is photography of china it removes the domain from url
                                    $domain = parse_url($link->getAttribute('href'), PHP_URL_HOST);
                                    if ( $domain === 'photographyofchina.com' ) {
                                      $tmp2['href'] = parse_url($link->getAttribute('href'), PHP_URL_PATH);
                                    }
                                    else{
                                      $tmp2['href'] = $link->getAttribute('href');
                                    }
                                  }
                                  $tmp2['src'] = $tmp_src;
                                  preg_match($mediaRegex, $tmp_src, $mediaMatches);
                                  if (!empty($mediaMatches[1])) {
                                    $medias[$mediaMatches[1]] = $tmp_src;
                                    $tmp2['src'] = 'media/'.$mediaMatches[1];
                                  }
                                  $srcs[] = $tmp2['src'];
                                  if ($captions = $slide->getElementsByTagName('div')) {
                                    foreach ($captions as $c) {
                                      $cclasses = explode(' ',$c->getAttribute('class'));
                                      if (in_array('image-slide-title', $cclasses)) {
                                        $caption = trim($c->textContent);
                                        if ($caption) {
                                          $tmp2['caption'] = $caption;
                                          break;
                                        }
                                      }
                                    }
                                  }
                                  $images[] = $tmp2;
                                }
                              }
                            }
                          }
                        }
                      }
                      elseif (($child->tagName === 'img') && ($tmp_src = $child->getAttribute('src'))) {
                        //case of div without class containing a gallery of images
                        $tmp2['src'] = $tmp_src;
                        preg_match($mediaRegex, $tmp_src, $mediaMatches);
                        if (!empty($mediaMatches[1])) {
                          $medias[$mediaMatches[1]] = $tmp_src;
                          $tmp2['src'] = 'media/'.$mediaMatches[1];
                        }
                        $images[] = $tmp2;
                        $srcs[] = $tmp2['src'];
                      }
                    }
                    $tmp['source'] = $images;
                  }

                  //CASE CAROUSEL
                  else if ( !empty($attr_class) && in_array('sqs-gallery-design-carousel', $attr_class) ){
                    $tmp['type'] = 'carousel';
                    $images = [];
                    foreach ($c->childNodes as $child) {
                      if ( $child->tagName && ($child->tagName === 'div')) {
                        $child_classes =  explode(' ', $child->getAttribute('class'));

                        if (in_array('sqs-gallery-container', $child_classes) && !empty($child->childNodes)) {

                          foreach ($child->childNodes as $gallery) {
                            if ($gallery->tagName && ($gallery->tagName === 'div')){

                              $classes = explode(' ',$gallery->getAttribute('class'));
                              if (in_array('sqs-gallery', $classes) && !empty($gallery->childNodes)) {
                                foreach ($gallery->childNodes as $slide) {
                                  if ($slide->tagName && ($slide->tagName === 'div')){
                                    $item_classes = array_map(function($a){
                                      if ( !empty($a) ){
                                        return trim($a);
                                      }
                                    },explode(' ',$slide->getAttribute('class')));
                                    if ( in_array('summary-item', $item_classes) && !empty($slide->childNodes) ){
                                      $image = [];
                                      $img = $slide->getElementsByTagName('img');
                                      $img = $img[0];
                                      $links = $slide->getElementsByTagName('a');
                                      if($times = $slide->getElementsByTagName('time')){
                                        $time = $times[0];
                                        //for the carousels of the home!
                                        $image['time'] = $time->textContent;
                                      }
                                      $link = $links[0];
                                      if ( !empty($link) && !empty($img) && $img->hasAttribute('data-src')  ){
                                        $image['src'] = $img->getAttribute('data-src');
                                        preg_match($mediaRegex, $image['src'], $mediaMatches);
                                        if (!empty($mediaMatches[1])) {
                                          $medias[$mediaMatches[1]] = $image['src'];
                                          $image['src'] = 'media/'.$mediaMatches[1];
                                        }
                                        $srcs[] =  $image['src'];

                                        //looking for the price
                                        $price = '';
                                        if( $slide->childNodes ){
                                          foreach($slide->childNodes as $i => $pc){
                                            if ( $pc->tagName &&  $pc->getAttribute('class') && in_array('summary-content',explode(' ',$pc->getAttribute('class')))){
                                              if($pc->childNodes){
                                                foreach($pc->childNodes as $n){
                                                  if($n->tagName &&  $n->getAttribute('class') && in_array('summary-price',explode(' ',$n->getAttribute('class')))){
                                                    foreach( $n->childNodes as $o ){
                                                      if($o->tagName && $o->getAttribute('class') && in_array('product-price',explode(' ',$o->getAttribute('class')))){

                                                        if( $o->textContent ){
                                                          $full_price = trim($o->textContent);
                                                          $number = '';
                                                          $letters = '';
                                                          $number = filter_var($image['price']);
                                                          $tmpo = explode(' ',$full_price);
                                                          foreach($tmpo as $t){
                                                            if(is_numeric($t)){
                                                              $number = '€ '.$t;
                                                            }
                                                            else{
                                                              $letters = $t.' ';
                                                            }
                                                          }
                                                          $image['price'] = $letters.$number;
                                                          $image['is_product'] = true;

                                                        }
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }

                                        $image['href'] = $link->getAttribute('href');
                                        $image['title'] = $link->getAttribute('data-title');
                                        $images[] = $image;
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                    $tmp['source'] = $images;

                  }
                  //CASE IMAGE
                  else if ( !empty($attr_class) && in_array('image-block-outer-wrapper', $attr_class) ){
                    //template inline
                    if(
                      in_array('design-layout-inline',$attr_class) &&
                      ($c->parentNode->tagName === 'body')
                    ){
                      $tmp['inline'] = true;
                    }

                    $image = [];
                    if ( !empty($c->childNodes) && ($child = $c->getElementsByTagName('figure')[0])){
                      if ( $child->hasAttribute('style') ){
                        $tmp_style =  explode(';',$child->getAttribute('style'));
                        if ( !empty($tmp_style) ){
                          $style = [];
                          foreach( $tmp_style as $t ){
                            if (!empty($t)){
                              $style[explode(':', $t)[0]] = explode(':', $t)[1];
                            }
                          }
                          $tmp['style'] = $style;
                        }
                      }

                      if ( $link = $child->getElementsByTagName('a')[0] ){
                        if ( (strpos($link->getAttribute('class'), 'sqs-block-image-link') > -1) && $link->hasAttribute('href') ){
                          $tmp['href'] = $link->getAttribute('href');
                          $img = $link->getElementsByTagName('noscript')[0]->getElementsByTagName('img')[0];
                          $tmp['src'] = $img->getAttribute('src');
                          preg_match($mediaRegex, $tmp['src'], $mediaMatches);
                          if (!empty($mediaMatches[1])) {
                            $medias[$mediaMatches[1]] = $tmp['src'];
                            $tmp['src'] = 'media/'.$mediaMatches[1];
                          }

                          $srcs[] = $tmp['src'];
                        }
                      }
                      if ( !isset($tmp['src']) && ($container = $child->getElementsByTagName('div')[0]) ){
                        if ( strpos($container->getAttribute('class'),'image-block-wrapper') > -1){
                          $img = $container->getElementsByTagName('noscript')[0]->getElementsByTagName('img')[0];
                          $tmp['src'] = $img->getAttribute('src');
                          preg_match($mediaRegex, $tmp['src'], $mediaMatches);
                          if (!empty($mediaMatches[1])) {
                            $medias[$mediaMatches[1]] = $tmp['src'];
                            $tmp['src'] = 'media/'.$mediaMatches[1];
                          }

                          $srcs[] =  $tmp['src'];
                          $caption = $container->getElementsByTagName('figcaption');

                        }
                        if ( $child->getElementsByTagName('figcaption') ){
                          $caption = $child->getElementsByTagName('figcaption')[0]->textContent;
                          $tmp['caption'] = htmlentities($caption);
                        }
                      }
                    }
                    //the type of block is image only if it has the attr src
                    if (!empty($tmp['src'])) {
                      $tmp['type'] = 'image';
                    }
                  }
                  else if( !empty($attr_class) && in_array('product-block', $attr_class) ){
                    if ( !empty($c->childNodes) && ($link = $c->getElementsByTagName('a')[0])){
                      $src = $link->getElementsByTagName('img');
                      $src = $src[0];
                      if ( $src && $src->getAttribute('data-src') ){
                        $tmp['src'] = $src->getAttribute('data-src');
                        preg_match($mediaRegex, $tmp['src'], $mediaMatches);
                        if (!empty($mediaMatches[1])) {
                          $medias[$mediaMatches[1]] = $tmp['src'];
                          $tmp['src'] = 'media/'.$mediaMatches[1];
                        }

                        $srcs[] = $tmp['src'];
                      }
                      if($link->getAttribute('href')){
                        $tmp['href'] = $link->getAttribute('href');
                      }
                      if($src && $src->getAttribute('alt')){
                        $tmp['alt'] = $src->getAttribute('alt');
                      }
                      if (!empty($tmp['src'])) {
                        $tmp['type'] = 'image';
                      }
                      if ($div = $c->getElementsByTagName('div')) {
                        foreach($div as $d){
                          $class = explode(' ',$d->getAttribute('class'));
                          if (in_array('productDetails', $class)){
                            if ($d->getElementsByTagName('a') && ($a = $d->getElementsByTagName('a')[0]) ){

                              $tmp['details_title'] = trim($a->textContent);
                            }
                            if ($d->getElementsByTagName('p') && ($p = $d->getElementsByTagName('p')[0]) ){
                              $tmp['details'] = trim($p->textContent);
                            }
                          }
                        }
                      }

                    }

                  }

                  //try to get other images that does not have way to be recognized
                  else {
                    if($otherImg = $c->getElementsByTagName('img')){
                      foreach($otherImg as $o){
                        if (empty($o->getAttribute('id')) || ($o->getAttribute('id') !== 'socialLinks')){
                          if ( $o->getAttribute('src') ){
                            $tmp2['src'] = $o->getAttribute('src');
                          }
                          else if($o->getAttribute('data-src')){
                            $tmp2['src'] = $o->getAttribute('data-src');
                          }
                          preg_match($mediaRegex, $tmp2['src'], $mediaMatches);
                          if (!empty($mediaMatches[1])) {
                            $medias[$mediaMatches[1]] = $tmp2['src'];
                            $tmp2['src'] = 'media/'.$mediaMatches[1];
                          }
                          if ($o->parentNode->parentNode->tagName === 'a'){
                            $tmp2['details_title'] =  $o->parentNode->parentNode->getAttribute('data-title') ?? '';
                            $tmp2['details'] = $o->parentNode->parentNode->getAttribute('data-description') ?? '';
                            $tmp2['href'] = $o->parentNode->parentNode->getAttribute('href');
                          }
                          if ($o->getAttribute('alt')){
                            $tmp2['alt'] = $o->getAttribute('alt');
                          }
                          if(!in_array( $tmp2['src'],$srcs)){
                            $tmp['type'] = 'gallery';
                            $tmp['source'][] = $tmp2;
                            $tmp['columns'] = 2;
                            $tmp['style']['width'] = '100%';
                            $tmp['noSquare'] = true;
                          }
                        }
                      }
                    }
                  }

                  break;
              }
              if ( isset($tmp['type'])){
                //creates the object of style from the string
                if ( $c->hasAttribute('style') ){
                  $tmp_style =  explode(';',$c->getAttribute('style'));
                  if ( !empty($tmp) ){
                    $style = [];
                    foreach( $tmp_style as $t ){
                      if (!empty($t)){
                        $style[explode(':', $t)[0]] = explode(':', $t)[1];
                      }
                    }
                    $tmp['style'] = $style;
                  }
                }
                $tmp['align'] = (!empty($tmp['style']) && isset($tmp['style']['text-align'])) ? $tmp['style']['text-align'] : 'left';
              }
              else {
                if (($c->tagName !== 'style' && $c->tagName !== 'div') || ($c->tagName === 'div' && $c->getAttribute('class') !== '')) {
                  $failedTag[$azerty] = $tmp;
                  $failedTag[$azerty]['tagName'] = $c->tagName;
                  $failedTag[$azerty]['file'] = basename($f);
                  $failedTag[$azerty]['class'] = $c->getAttribute('class');
                  $azerty += 1;
                  $failedPath = $model->contentPath().'failed/';
                  $fs->putContents($failedPath.basename($f), $st);
                  if ($failedTag['tagCount'] === null) {
                    $failedTag['tagCount'] = [];
                  }
                  else {
                    if ($failedTag['tagCount'][$c->tagName] === null) {
                      $failedTag['tagCount'][$c->tagName] = 1;
                    }
                    else {
                      $failedTag['tagCount'][$c->tagName] += 1;
                    }
                  }
                } 
              }
              $blocks[] = $tmp;
            }
          }

          //if there's a block with the property inline=true analyze siblings and set the prop inline

          //detect if the block type TITLE is between HR, (it has a block type hr before and one after and align is center ONLY WAY TO KNOW IF THE TITLE IS IN HR)
          foreach($blocks as $i => $block){
            $before = $i - 1;
            $after = $i + 1;

            if (
              ($blocks[$i]['type'] === 'title') &&
              ($blocks[$i]['align'] === 'center') &&
              ($blocks[$i-1]['type'] === 'line') &&
              ($blocks[$i+1]['type'] === 'line')
            ) {
              $blocks[$i]['hr'] = (bool)true;
              //removes the first block hr from the array blocks
              array_splice($blocks, $before, 1);
              //removes the block hr after title in the array blocks ($after-1 because one index has already been deleted from the array)
              array_splice($blocks, $after - 1, 1);
            }
          }
          //remove empty index from blocks
          $last_blocks = [];
          //CREATES the tag of the component to insert in db for each block
          $all_tag = '';
          //die(X::dump($blocks));

          foreach( $blocks as $block ){
            if (!empty($block) && !empty($block['type'])) {
              //*$block['bbn_tag'] = '';
              $bbn_tag = '<bbn-cms-block ';
              //type
              $bbn_tag .= 'type="' . $block['type'] .'" ';

              //align
              isset($block['align']) ? ( $bbn_tag .= 'align="' . $block['align'] .'" ' ) : false;
              //hr
              isset($block['hr']) ? ( $bbn_tag .= ':hr="' . boolval($block['hr']) .'" ' ) : false;
              //noSquare
              isset($block['noSquare']) ? ( $bbn_tag .= ':noSquare="' . boolval($block['noSquare']) .'" ' ) : false;
              //columns
              isset($block['columns']) ? ( $bbn_tag .= 'columns="' . $block['columns'] .'" ' ) : false;
              //content
              if (isset($block['content'])) {
                $bbn_tag .= 'content="' . $block['content'] .'" ';
              }
              //tag
              isset($block['tag']) ? ( $bbn_tag .= 'tag="' . $block['tag'] .'" ' ) : false;
              //src for image
              isset($block['src']) ? ( $bbn_tag .= 'src="' . $block['src'] .'" ' ) : false;
              //caption for image
              if (isset($block['caption'])) {
                $bbn_tag .= 'caption="' . $block['caption'] .'" ';
              }

              if (!empty($block['style'])) {
                $style = '';
                foreach($block['style'] as $prop => $val){
                  $style .= $prop.':'.$val.';';
                }
                $bbn_tag .= 'style="'.$style.'"';
              }

              if ( ($block['type'] === 'gallery') || ($block['type'] === 'carousel') && !empty($block['source'])){
                $bbn_tag .= ':source="[';
                foreach($block['source'] as $source ){
                  $bbn_tag .= '{';
                  foreach($source as $i => $s){
                    $bbn_tag .= $i . ':\'' . $s . '\',';
                  }
                  $bbn_tag .= '},';

                }
                $bbn_tag .= ']"';
              }


              //because only block image has the class to detect the inline view
              $inlineIdx = bbn\X::find($blocks, ['inline' => true]);
              if (
                isset($inlineIdx) &&
                isset($block['type']) &&
                ($block['type'] !== 'hr') &&
                ($block['type'] !== 'title') &&
                ($block['node']->parentNode->tagName === 'body')
              ) {
                $block['inline'] = true;
                //inline
                $bbn_tag .= ':inline="' . $block['inline'] .'" ';
              }
              $bbn_tag .= '></bbn-cms-block>';
              $all_tag .= $bbn_tag;
              array_splice($block, 0, 1);
              if(!empty($block['type'])){
                $last_blocks[] = $block;
              }


            }
          }
        }
        else{
          continue;
        }

        $res[$f]['bbn_elements'] = $all_tag;
        $res[$f]['bbn_cfg'] = json_encode($last_blocks);

        $res[$f]['content'] = (string)($dom->{'content:encoded'} ?? '');
        $json_file = pathinfo($f)['filename'] . '.json';
        if (file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'blocks/'.$json_file, json_encode($res[$f], JSON_UNESCAPED_UNICODE))) {
          $num_inserted++;
        }
        $res[$f] = null;
        $dom = null;
      }

      //}
      file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'ids2.json', json_encode($ids));

      //creates json file of categories
      file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'categories.json', json_encode($categories));

      file_put_contents(APPUI_NOTE_CMS_IMPORT_PATH.'medias.json', json_encode($medias));


    }

    return ['test' => $failedTag, 'message' => 'Process launch successfully, '.$num_inserted.' JSON files created'];
  }
}