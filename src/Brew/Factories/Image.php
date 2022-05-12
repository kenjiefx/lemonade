<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew\Factories;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class Image {

    public const PATH = '/theme/images';
    public const TYPE = 'image';
    private string $imgPath;

    public function __construct(
        private string $path
        )
    {
        $this->locate();
    }

    private function locate()
    {
        try {

            $this->imgPath = ROOT.Image::PATH.$this->path;

            if (!file_exists($this->imgPath)) {
                throw new BuildTargetNotFoundException(
                    "Error::Build Target Not Found: {$this->imgPath}"
                );
            }

        } catch (\Exception $e) {
            exit($e->getMessage());
        }

    }

    public function __toString()
    {
        return $this->imgPath;
    }


}
