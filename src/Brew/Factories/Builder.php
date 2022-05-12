<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew\Factories;
use Kenjiefx\Lemonade\Brew\HTMLBuilder;
use Kenjiefx\Lemonade\Brew\ScriptBuilder;
use Kenjiefx\Lemonade\Brew\CSSBuilder;
use Kenjiefx\Lemonade\Brew\DataMap;
use Kenjiefx\Lemonade\Brew\ImageDispatcher;
use Kenjiefx\Lemonade\Brew\Factories\Module;
use Kenjiefx\Lemonade\Brew\Factories\Target;
use GuzzleHttp\Psr7\Uri;

class Builder {

    public const PREVIEW = FALSE;
    public const LIVE = TRUE;

    public static function module(
        string $title,
        Uri $uri,
        bool $mode
        )
    {
        $build = new HTMLBuilder(
            new Target(Target::MODULE,$title),
            $mode,
            new DataMap($uri,$mode),
        );
        return $build;
    }

    public static function template(
        string $title,
        Uri $uri,
        bool $mode
        )
    {
        $build = new HTMLBuilder(
            new Target(Target::TEMPLATE,$title),
            $mode,
            new DataMap($uri,$mode),
        );
        return $build;
    }


    public static function script(
        string $namespace,
        bool $mode
        )
    {
        $build = new ScriptBuilder(
            new Target(Target::SCRIPT,$namespace),
            $mode
        );
        $build->map();
        return $build;
    }

    public static function style(
        string $namespace,
        bool $mode
        )
    {
        $build = new CSSBuilder(
            new Target(Target::STYLE,$namespace),
            $mode
        );
        return $build;
    }

    public static function image(
        string $path
        )
    {
        $build = new ImageDispatcher(
            new Target(Target::IMAGE,$path)
        );
        return $build;
    }

}
