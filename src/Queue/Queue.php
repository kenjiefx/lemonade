<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Queue;

class Queue {

    public function __construct(
        private string $path,
        private string $hook,
        private string $template
        )
    {

    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getHook()
    {
        return $this->hook;
    }

    public function getPath()
    {
        return $this->path;
    }

}
