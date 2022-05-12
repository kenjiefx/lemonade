<?php

use Kenjiefx\Lemonade\Render;
use Kenjiefx\Lemonade\Feed;
define('ROOT',__DIR__);
require ROOT.'/vendor/autoload.php';

$feed = [
    'queue' => [
        'products' => [
            'hook' => 'product' ,
            'template' => 'product-template'
        ]
    ]
];

Render::create(new Feed($feed));
