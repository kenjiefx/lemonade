<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade\Queue;

class QueueManager {

    public const ADDRESS = 'http://localhost:5050/build/template';

    public function __construct()
    {

    }

    public function run(
        array $queues
        )
    {
        foreach ($queues as $queue) {
            foreach (scandir($queue->getPath()) as $file) {
                if ($file!=='.'&&$file!=='..') {
                    $fileDir = urlencode($queue->getPath());
                    $resolvedPath = Self::ADDRESS."/{$queue->getTemplate()}?source={$file}&look={$fileDir}&name={$queue->getHook()}";
                    echo $resolvedPath.PHP_EOL;
                    $rendered = file_get_contents($resolvedPath);
                    echo $rendered;
                }
            }

        }
    }

}
