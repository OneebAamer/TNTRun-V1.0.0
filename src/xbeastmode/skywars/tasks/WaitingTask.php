<?php
namespace xbeastmode\skywars\taks;
use pocketmine\scheduler\PluginTask;
use xbeastmode\skywars\Loader;
class WaitingTask extends PluginTask{
    /** @var Loader */
    private $plugin;
    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader){
        parent::__construct($loader);
        $this->plugin = $loader;
    }
    /**
     * Actions to execute when run
     *
     * @param $currentTick
     *
     * @return void
     */
    public function onRun($currentTick)
    {
        // TODO: Implement onRun() method.
    }
}
