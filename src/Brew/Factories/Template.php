<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew\Factories;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class Template {

    public const PATH = '/theme/templates/';
    public const TYPE = 'template';
    private string $tempPath;

    public function __construct(
        private string $title
        )
    {
        $this->locate();
    }

    private function locate()
    {
        try {

            $this->tempPath = ROOT.Template::PATH."{$this->title}.php";

            if (!file_exists($this->tempPath)) {
                throw new BuildTargetNotFoundException(
                    "Error::Build Target Not Found: {$this->tempPath}"
                );
            }

        } catch (\Exception $e) {
            exit($e->getMessage());
        }

    }

    public function __toString()
    {
        return $this->tempPath;
    }


}
