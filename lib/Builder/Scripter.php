<?php

namespace Kenjiefx\Lemonade\Builder;
use Kenjiefx\Lemonade\Builder\Builder;

class Scripter {

    public static function js(
        string $scriptName
        )
    {
        $scriptDir = Build::getProjectRoot().'/app/scripts/'.$scriptName;
        if (!is_dir($scriptDir)) {
            return "// Script directory not found: ".$scriptName;
        }
        $scriptContent = '';
        foreach (Scripter::getDir($scriptDir) as $file) {
            $scriptContent .= file_get_contents($scriptDir.'/'.$file);
        }
        return $scriptContent;
    }

    public static function main()
    {
        $scriptDir = Build::getProjectRoot().'/app/scripts/main-js';
        $scriptContent = file_get_contents($scriptDir.'/.main.js');
        # Factories
        $factoriesDir = $scriptDir.'/Factories';
        foreach (Scripter::getDir($factoriesDir) as $file) {
            $scriptContent .= file_get_contents($factoriesDir.'/'.$file);
        }
        # Services
        $servicesDir = $scriptDir.'/Services';
        foreach (Scripter::getDir($servicesDir) as $file) {
            $scriptContent .= file_get_contents($servicesDir.'/'.$file);
        }
        # Scopes
        foreach (Scripter::getDir($scriptDir) as $file) {
            if (
                $file !== 'Factories' &&
                $file !== 'Services' &&
                $file !== '.main.js'
            ) {
                $scriptContent .= file_get_contents($scriptDir.'/'.$file);
            }
        }
        return $scriptContent;
    }

    private static function getDir(
        string $dirPath
        )
    {
        $files = scandir($dirPath);
        array_shift($files);
        array_shift($files);
        return $files;
    }

}
