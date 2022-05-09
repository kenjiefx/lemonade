<?php

namespace Kenjiefx\Lemonade\Builder;
use Kenjiefx\Lemonade\Builder\Scripter;
use Kenjiefx\Lemonade\Builder\Stylus;

class Build {

    public static function module(
        string $moduleTitle
        )
    {
        $data['projectRoot'] = Self::getProjectRoot();
        $data['title'] = 'Module Previewer: '.$moduleTitle;
        $data['viewType'] = 'PREVIEW';
        $data['previewType'] = 'module';
        $data['contentFor'] = "/modules/{$moduleTitle}.php";
        require(__DIR__.'/Views/functions.php');
        require(__DIR__.'/Views/index.php');
    }

    public static function data(
        string $dataType,
        string $dataTitle
        )
    {
        $path = Self::getProjectRoot()."/test/data/{$dataType}/{$dataTitle}.json";
        if (!file_exists($path)) {
            return [
                "status" => 404,
                "data" => [
                    "routedTo" => $path
                ]
            ];
        }
        return [
            "status" => 200,
            "data" => json_decode(file_get_contents($path),TRUE)
        ];
    }

    public static function script(
        string $scriptName
        )
    {
        if ($scriptName==='main-js') {
            return Scripter::main($scriptName);
        }
        return Scripter::js($scriptName);
    }

    public static function css(
        string $type
        )
    {
        if ($type==='GLOBAL') {
            return Stylus::global();
        }
        return Stylus::preview();
    }

    public static function getProjectRoot()
    {
        return APP_ROOT;
    }

}
