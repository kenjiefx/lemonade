<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew;
use Kenjiefx\Lemonade\Brew\Factories\Target;
use Kenjiefx\Lemonade\Brew\DataMap;

class HTMLBuilder {

    public function __construct(
        private Target $target,
        private bool $isLiveBuild,
        private DataMap $dataMap
        )
    {

    }

    public function build()
    {
        $this->functions()->index();
    }

    private function functions()
    {
        $GLOBALS['TARGET_OBJECT'] = $this->target->asArray();
        $GLOBALS['MAPPED_BUILD_DATA'] = $this->dataMap->map();
        $GLOBALS['PATH_TO_CONTENT'] = $this->target->locate();
        require(__DIR__.'/functions.php');
        return $this;
    }

    private function index()
    {
        require(ROOT.'/theme/index.php');
    }

}
