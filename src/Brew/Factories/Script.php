<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew\Factories;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class Script {

    public const PATH = '/theme/scripts/';
    public const TYPE = 'script';
    private string $scriptPath;

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

            $path = ROOT.Script::PATH.$namespace;

            if (!is_dir($path)) {
                throw new BuildTargetNotFoundException(
                    "Error::Build Target Not Found: {$path}"
                );
            }

            $this->scriptPath = $path;

        } catch (\Exception $e) {
            exit($e->getMessage());
        }

    }

    public function __toString()
    {
        return $this->scriptPath;
    }


}
