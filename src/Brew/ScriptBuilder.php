<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew;
use Kenjiefx\Lemonade\Brew\Factories\Target;
use Kenjiefx\Lemonade\Exceptions\BuildTargetNotFoundException;

class ScriptBuilder
{

    private array $map = [];

    public function __construct(
        private Target $target,
        private bool $isLiveBuild
        )
    {

    }

    public function map()
    {
        $path = $this->target->locate().'/build.json';
        if (file_exists($path)) {
            $this->map = json_decode(file_get_contents($path),TRUE);
        }
    }

    public function build()
    {
        $hierarchy = $this->getHierarchy();
        if (empty($hierarchy)) {
            $hierarchy = $this->scanAndSort(
                $this->target->locate(), []
            );
        }
        return $this->withHierarchy(
            $this->target->locate(),
            $hierarchy
        );
    }

    private function getHierarchy()
    {
        if (!empty($this->map)) {
            if (isset($this->map['hierarchy'])) {
                return $this->map['hierarchy'];
            }
        }
        return [];
    }

    private function withHierarchy(
        string $path,
        array $hierarchy
        )
    {
        $content = '';
        foreach ($hierarchy as $file => $subHierarchy) {
            $filePath = $path."/{$file}";
            try {
                if (!file_exists($filePath)) {
                    throw new BuildTargetNotFoundException(
                        "Error::Build Target Not Found: {$filePath}"
                    );
                }
                if (is_dir($filePath)) {
                    $resolvedHierarchy = $this->scanAndSort($filePath,$subHierarchy);
                    $content .= $this->withHierarchy($filePath,$resolvedHierarchy);
                } else {
                    $content .= file_get_contents($filePath);
                }
            } catch (\Exception $e) {
                exit($e->getMessage());
            }

        }
        return $content;
    }

    private function scanAndSort(
        string $dirPath,
        array $hierarchy
        )
    {
        $result = [];

        $dirFiles = scandir($dirPath);

        foreach ($hierarchy as $file => $subHierarchy) {
            $result[$file] = $subHierarchy;
        }

        foreach ($dirFiles as $file) {
            if ($file!=='.' && $file!=='..' && $file!=='build.json') {
                if (!isset($hierarchy[$file])) {
                    $result[$file] = [];
                }
            }
        }

        return $result;

    }


}
