<?php
declare(strict_types=1);
namespace Kenjiefx\Lemonade;
use Kenjiefx\Lemonade\Feed;
use Kenjiefx\Lemonade\Logger\Console;
use Kenjiefx\Lemonade\Queue\QueueManager;

class Render {

    private array $queue = [];

    public static function welcome()
    {
        return "Welcome to PlunkFramework!";
    }

    public function __construct(
        private QueueManager $QueueManager,
        private Feed $Feed
        )
    {

    }

    public static function create(
        Feed $feed
        )
    {
        $tStart = microtime(true);
        Console::success(Render::welcome());

        # Injecting QueueManager
        $render = new Render(new QueueManager(),$feed);

        $render->prepare()->execute()->end();

        Console::log('Total execution time in seconds: '.(microtime(true)-$tStart));

    }

    private function prepare()
    {
        $this->queue = $this->Feed->toQueue();
        return $this;
    }

    private function execute()
    {
        $this->QueueManager->run($this->queue);
        return $this;
    }

    private function end()
    {
        return $this;
    }

}
