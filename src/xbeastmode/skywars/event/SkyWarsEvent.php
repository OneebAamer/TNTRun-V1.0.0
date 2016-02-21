<?php
namespace xbeastmode\skywars\event;
use pocketmine\event\plugin\PluginEvent;
use xbeastmode\skywars\Loader;
abstract class SkyWarsEvent extends PluginEvent{
    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader){
        parent::__construct($loader);
    }
}
