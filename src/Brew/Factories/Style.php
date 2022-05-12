<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew\Factories;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class Style {

    public const PATH = '/theme/styles/';
    public const TYPE = 'stylesheet';
    private string $stylePath;

    public function __construct(
        private string $namespace
        )
    {
        $this->locate();
    }

    private function locate()
    {
        try {

            $namespace = str_replace('.','-',$this->namespace);

            $path = ROOT.Style::PATH.$namespace;

            if (!is_dir($path)) {
                throw new BuildTargetNotFoundException(
                    "Error::Build Target Not Found: {$path}"
                );
            }

            $this->stylePath = $path;

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function __toString()
    {
        return $this->stylePath;
    }


}
