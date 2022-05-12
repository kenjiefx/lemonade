<?php
use Slim\Factory\AppFactory;
use Kenjiefx\Lemonade\Brewer;
use Kenjiefx\Lemonade\Router;

define('ROOT',__DIR__);
require ROOT.'/vendor/autoload.php';

$app = AppFactory::create();
$brewer = new Brewer(new Router($app));
$brewer->brew()->serve();
