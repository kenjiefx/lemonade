<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Brew\Factories;


class Target {

    public const MODULE = 'Kenjiefx\Lemonade\Brew\Factories\Module';
    public const TEMPLATE = 'Kenjiefx\Lemonade\Brew\Factories\Template';
    public const SCRIPT = 'Kenjiefx\Lemonade\Brew\Factories\Script';
    public const STYLE = 'Kenjiefx\Lemonade\Brew\Factories\Style';
    public const IMAGE = 'Kenjiefx\Lemonade\Brew\Factories\Image';

    private object $target;

    public function __construct(
        private string $namespace,
        private string $title
        )
    {
        $this->target = new $namespace($title);
    }

    public function locate()
    {
        return (string)$this->target;
    }

    public function asArray()
    {
        $template = ($this->namespace::TYPE==='template') ? $this->title : null;
        return [
            'THEME' => '',
            'TEMPLATE' => $template
        ];
    }


}
