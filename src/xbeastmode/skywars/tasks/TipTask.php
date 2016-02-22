<?php
namespace xbeastmode\skywars\tasks;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;
use xbeastmode\skywars\game\SWManagement;
use xbeastmode\skywars\Loader;
use xbeastmode\skywars\utils\FMT;
class TipTask extends PluginTask{
    /** @var $game */
    private $game;
    /** @var Loader */
    private $plugin;
    /**
     * @param Loader $loader
     * @param $game
     */
    public function __construct(Loader $loader, $game){
        parent::__construct($loader);
        $this->plugin = $loader;
        $this->game = $game;
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
        $players = (new SWManagement($this->plugin))->getPlayers()[$this->game];
        foreach($players as $p){
            if($p instanceof Player){
                $msg = FMT::colorMessage($this->plugin->getMessage("Waiting_Tip"));
                $p->sendTip($msg);
            }
        }
    }
}
