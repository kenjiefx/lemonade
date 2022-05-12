<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade;
use Kenjiefx\Lemonade\Logger\Console;
use Kenjiefx\Lemonade\Queue\Queue;
use Kenjiefx\Lemonade\Exceptions\QueueNamespaceNotFoundException;

class Feed {

    private int $queueCount = 0;
    private const EMPTY_QUEUE = 'No queue data found in the feed file';

    public function __construct(
        private array $feed
        )
    {
        $this->setSource();
    }

    private function setSource()
    {
        if (!isset($this->feed['root'])) {
            $this->feed['root'] = ROOT.'/public/';
            return;
        }
    }

    public function toQueue()
    {

        $queue = [];

        if (!isset($this->feed['queue'])) {
            Console::warn(FEED::EMPTY_QUEUE);
            return;
        }
        if (empty($this->feed['queue'])) {
            Console::warn(FEED::EMPTY_QUEUE);
            return;
        }

        foreach ($this->feed['queue'] as $namespace => $queueable) {

            $path = $this->feed['root'].$namespace;

            array_push($queue,new Queue(
                $path,
                $queueable['hook'],
                $queueable['template'],
            ));

            $this->countQueueable($path);

        }

        Console::log('Found '.$this->queueCount.' file/s to queue');

        return $queue;

    }

    private function countQueueable(
        string $path
        )
    {
        try {
            if (!is_dir($path)) {
                throw new QueueNamespaceNotFoundException(
                    "Unable to queue directory: {$path}. Directory not found"
                );
            }

            $files = scandir($path);
            foreach ($files as $file) {
                if ($file!=='.'&&$file!=='..') {
                    $this->queueCount++;
                }
            }


        } catch (\Exception $e) {
            Console::error($e->getMessage());
            exit();
        }

    }

}
