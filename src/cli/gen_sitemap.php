<?php
use bbn\X;

$all = $ctrl->db->rselectAll([
  'tables' => ['bbn_notes_versions'],
  'fields' => ['bbn_url.url', 'lastmod' => 'DATE(GREATEST(bbn_notes_versions.creation, bbn_events.start))'],
  'join' => [
    [
      'table' => 'bbn_notes_events',
      'on' => [
        [
          'field' => 'bbn_notes_events.id_note',
          'exp' => 'bbn_notes_versions.id_note'
        ]
      ]
    ], [
      'table' => 'bbn_notes_url',
      'on' => [
        [
          'field' => 'bbn_notes_url.id_note',
          'exp' => 'bbn_notes_versions.id_note'
        ]
      ]
    ], [
      'table' => 'bbn_url',
      'on' => [
        [
          'field' => 'bbn_notes_url.id_url',
          'exp' => 'bbn_url.id'
        ]
      ]
    ], [
      'table' => 'bbn_events',
      'on' => [
        [
          'field' => 'bbn_notes_events.id_event',
          'exp' => 'bbn_events.id'
        ]
      ]
    ]
  ],
  'where' => [
    'latest' => 1,
    ['start', '<=', date('Y-m-d H:i:s')],
    [
      'logic' => 'OR',
      'conditions' => [
        [
          'field' => 'end',
          'operator' => 'isnull'
        ], [
          'field' => 'end',
          'operator' => '>=',
          'value' => date('Y-m-d H:i:s')
        ]
      ]
    ]
  ]
]);

$file = BBN_PUBLIC . 'sitemap.xml';

$content = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
EOD;
foreach ($all as $a) {
  $content .= '  <url>' . PHP_EOL;
  $content .= '    <loc>' . BBN_URL . $a['url'] . '</loc>' . PHP_EOL;
  $content .= '    <lastmod>' . $a['lastmod'] . '</lastmod>' . PHP_EOL;
  $content .= '  </url>' . PHP_EOL;
}

$content .= <<<EOD
</urlset>
EOD;

file_put_contents($file, $content);

echo _(sprintf("%s links created in sitemap", count($all)));
