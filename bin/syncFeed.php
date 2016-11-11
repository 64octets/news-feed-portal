#!/usr/bin/php
<?php

$options = getopt('f:u:', array('file:', 'url:'));

$params = [];

if (isset($options['f']) || isset($options['file'])) {
    $file = isset($options['f']) ? file_get_contents($options['f']) : file_get_contents($options['file']);
    $rss = simplexml_load_string($file);
} else if (isset($options['u']) || isset($options['url'])) {
    $rss = isset($options['p']) ? simplexml_load_file($options['u']) : simplexml_load_file($options['u']);
} else {
    die("XML file is required\n");
}

require_once(__DIR__.'/../vendor/autoload.php');

foreach ($rss->channel->item as $item) {
    $date = new \DateTime((string) $item->pubDate);
    $params = [
        'Title'         => (string) $item->title,
        'Description'   => (string) $item->description,
        'Author'        => (string) $item->author,
        'PubDate'       => $date->format('Y-m-d'),
        'PubTime'       => $date->format('H:i:s'),
        'Thumbnail'     => (string) $item->children('media', true)->thumbnail->attributes()->url,
        'Source'        => (string) $item->children('media', true)->content->attributes()->url,
    ];

    $syncFeed = new Scripts\SyncFeed('syncFeed', $params);
    $syncFeed->run();
}
