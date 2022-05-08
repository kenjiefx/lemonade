<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Kenjiefx\Lemonade\Builder\Build;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/preview/module/{moduleTitle}', function (Request $request, Response $response, $args) {
    Build::module($args['moduleTitle']);
    return $response;
});

$app->get('/data/project/{projectTitle}', function (Request $request, Response $response, $args) {
    $data = Build::data('project',$args['projectTitle']);
    if ($data['status']===404) {
        $response->getBody()->write(json_encode($data['data']));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
    }
    $response->getBody()->write(json_encode($data['data']));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
    return $response;
});

$app->get('/app/script/{scriptName}', function (Request $request, Response $response, $args) {
    $script = Build::script($args['scriptName']);
    $response->getBody()->write($script);
    return $response
        ->withHeader('Content-Type', 'text/javascript')
        ->withStatus(200);
});

$app->get('/app/styles/global-css', function (Request $request, Response $response, $args) {
    $css = Build::css('GLOBAL');
    $response->getBody()->write($css);
    return $response
        ->withHeader('Content-Type', 'text/css')
        ->withStatus(200);
});

$app->get('/app/styles/previewer-css', function (Request $request, Response $response, $args) {
    $css = Build::css('PREVIEW');
    $response->getBody()->write($css);
    return $response
        ->withHeader('Content-Type', 'text/css')
        ->withStatus(200);
});








$app->run();
