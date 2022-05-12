<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade;
use Kenjiefx\Lemonade\Router;

class Brewer
{
    public function __construct(
        private Router $router
        )
    {
        
    }

    public function brew()
    {
        $this->router->route();
        return $this;
    }

    public function serve()
    {
        $this->router->serve();
    }

}
