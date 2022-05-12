<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Kenjiefx\Lemonade\Brew\Factories\Builder;
use Slim\App;

class Router {

    public function __construct(
        private App $app
        )
    {

    }

    public function route()
    {

        $this->app->get('/', function (Request $request, Response $response, $args) {
            $response->getBody()->write("Hello world!");
            return $response;
        });

        # Builds Modules only, wraps around index.php
        $this->app->get('/preview/module/{title}', function (Request $request, Response $response, $args) {
            $builder = Builder::module(
                $args['title'],
                $request->getUri(),
                Builder::PREVIEW
            );
            $builder->build();
            return $response;
        });

        # Builds Templates only, wraps around index.php
        $this->app->get('/preview/template/{title}', function (Request $request, Response $response, $args) {
            $builder = Builder::template(
                $args['title'],
                $request->getUri(),
                Builder::PREVIEW
            );
            $builder->build();
            return $response;
        });

        $this->app->get('/build/template/{title}', function (Request $request, Response $response, $args) {
            $builder = Builder::template(
                $args['title'],
                $request->getUri(),
                Builder::LIVE
            );
            $builder->build();
            return $response;
        });

        $this->app->get('/scripts/{namespace}', function (Request $request, Response $response, $args) {
            $builder = Builder::script(
                $args['namespace'],
                Builder::LIVE
            );
            $response->getBody()->write($builder->build());
            return $response
                ->withHeader('Content-Type', 'text/javascript')
                ->withStatus(200);
        });

        $this->app->get('/styles/{namespace}', function (Request $request, Response $response, $args) {
            $builder = Builder::style(
                $args['namespace'],
                Builder::LIVE
            );
            $response->getBody()->write($builder->build());
            return $response
                ->withHeader('Content-Type', 'text/css')
                ->withStatus(200);
        });

        $this->app->get('/favicon.ico', function (Request $request, Response $response, $args) {
            $builder = Builder::image('/favicon.ico');
            $response->getBody()->write($builder->build());
            return $response
                ->withHeader('Content-Type', 'image/x-icon')
                ->withStatus(200);
        });

    }

    public function serve()
    {
        try {
            $this->app->run();
        } catch (\Exception $e) {
            echo "Route not found";
        }

    }

}
