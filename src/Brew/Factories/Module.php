<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew\Factories;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class Module {

    public const PATH = '/theme/modules/';
    public const TYPE = 'module';
    private string $modPath;

    public function __construct(
        private string $title
        )
    {
        $this->locate();
    }

    private function locate()
    {
        try {

            $this->modPath = ROOT.Module::PATH."{$this->title}.php";

            if (!file_exists($this->modPath)) {
                throw new BuildTargetNotFoundException(
                    "Error::Build Target Not Found: {$this->modPath}"
                );
            }

        } catch (\Exception $e) {
            exit($e->getMessage());
        }

    }

    public function __toString()
    {
        return $this->modPath;
    }


}
