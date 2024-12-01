<!-- HTML Document -->
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="<?= $lang ?>"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="<?= $lang ?>"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="<?= $lang ?>"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="<?= $lang ?>"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="<?= $lang ?>"><!--<![endif]-->
<base href="<?= $site_url ?>" target="_self">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="author" content="BBN Solutions">
<meta name="Copyright" content="<?= _("All rights reserved.") ?>">
<meta http-equiv="expires" content="Fri, 22 Jul 2002 11:12:01 GMT">
<!--meta http-equiv="Cache-control" content="private">
<meta http-equiv="cache-control" content="no-store"-->
<meta http-equiv="Cache-control" max-age="31536000">
<link rel="apple-touch-icon" sizes="57x57" href="<?= $static_path ?>img/favicon/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?= $static_path ?>img/favicon/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?= $static_path ?>img/favicon/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?= $static_path ?>img/favicon/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?= $static_path ?>img/favicon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?= $static_path ?>img/favicon/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?= $static_path ?>img/favicon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?= $static_path ?>img/favicon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?= $static_path ?>img/favicon/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="<?= $static_path ?>img/favicon/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?= $static_path ?>img/favicon/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="<?= $static_path ?>img/favicon/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="<?= $static_path ?>manifest.json">
<link rel="mask-icon" href="<?= $static_path ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#9f00a7">
<meta name="msapplication-TileImage" content="<?= $static_path ?>img/favicon/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta name="viewport" content="initial-scale=0.66, User-scalable=no">
<title><?= $title . ' - ' . constant('BBN_SITE_TITLE') ?></title>

<div id="container" style="opacity: 0">
  <div class="appui-cms-preview bbn-overlay bbn-lpadding bbn-bg-white" style="transition: opacity 5s">
    <h1 bbn-if="source.title"
        bbn-html="source.title"
        class="bbn-vpadding bbn-margin bbn-c"></h1>
    <div bbn-for="(cfg, i) in source.items">
      <appui-note-cms-block :source="cfg"
                            :ref="'block' + i"
                            :selectable="false"
                            :overable="false"></appui-note-cms-block>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?=BBN_SHARED_PATH?>?<?=http_build_query([
  'lang' => BBN_LANG,
  'lib' => 'animate-css,bbn-css|master|' . BBN_THEME . ',bbn-vue,font-mfizz,webmin-font,jsPDF,html2canvas',
  'test' => BBN_IS_DEV
])?>"></script>
<script>
  const data = <?= json_encode($data) ?>;
  document.addEventListener("DOMContentLoaded", () => {
    <?= $script ?>
    document.getElementById('container').style.opacity = 1;
  });
</script>
