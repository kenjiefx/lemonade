<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew;
use Kenjiefx\Lemonade\Brew\Factories\Target;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class ImageDispatcher {

    public function __construct(
        private Target $target
        )
    {
        
    }

    public function build()
    {
        return file_get_contents($this->target->locate());
    }

}
