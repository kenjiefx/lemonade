<?php

namespace Kenjiefx\Lemonade\Builder;
use Kenjiefx\Lemonade\Builder\Builder;

class Stylus {

    public static function global()
    {
        $css = '* {margin:0;padding:0;box-sizing:border-box;} ';
        $css .= Stylus::getRoot('global').' ';
        $css .= Stylus::compile('global');
        return $css;
    }

    public static function preview()
    {
        $css = '';
        $css .= Stylus::compile('previewer');
        return $css;
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

    private static function getNamespaceDir(
        string $namespace
        )
    {
        return Build::getProjectRoot()."/app/styles/{$namespace}";
    }

    private static function getRoot(
        string $namespace
        )
    {
        $path = Stylus::getNamespaceDir($namespace)."/.root.css";
        if (!file_exists($path)) {
            return '';
        }
        return file_get_contents($path);
    }

    private static function compile(
        string $namespace
        )
    {
        $files = scandir(Stylus::getNamespaceDir($namespace));
        $compiled = '';
        foreach ($files as $file) {
            if (
                $file==='.'||
                $file==='..'||
                $file==='.root.css'
            ) {
                continue;
            }
            $compiled .= file_get_contents(Stylus::getNamespaceDir($namespace).'/'.$file);
        }
        return $compiled;
    }




}
