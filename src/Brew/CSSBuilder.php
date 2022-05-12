<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew;
use Kenjiefx\Lemonade\Brew\Factories\Target;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class CSSBuilder
{
    private array $map = [];

    public function __construct(
        private Target $target,
        private bool $isLiveBuild
        )
    {

    }

    public function build()
    {
        return $this->compile();
    }

    private function compile()
    {
        $compiled = '';
        $dirPath = $this->target->locate();
        $files = scandir($dirPath);
        foreach ($files as $file) {
            if ($file!=='.' && $file!=='..') {
                $compiled .= file_get_contents($dirPath."/{$file}");
            }
        }
        return $compiled;
    }
}
