<?php
namespace xbeastmode\skywars\taks;
use pocketmine\scheduler\PluginTask;
use pocketmine\tile\Sign;
use xbeastmode\skywars\game\SWGame;
use xbeastmode\skywars\game\SWManagement;
use xbeastmode\skywars\Loader;
use xbeastmode\skywars\utils\FMT;

class SignRefreshTask extends PluginTask{
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
        foreach($this->plugin->getServer()->getLevels() as $lvl){
            foreach($lvl->getTiles() as $t){
                if($t instanceof Sign){
                    $l2 = FMT::b($t->getText()[1]);
                    if(strtolower($l2) === "skywars" and isset($this->plugin->skyWarsConfig()->getAll()[$l2])) {
                        $l1 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_1"));
                        $l2 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_2"));
                        $l3 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_3"));
                        $l4 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_4"));
                        $count = null;
                        if(isset((new SWManagement($this->plugin))->getPlayers()[$l2])){
                            $count = count((new SWManagement($this->plugin))->getPlayers()[$l2]);
                        }else{
                            $count = 0;
                        }
                        $max = (new SWGame($this->plugin))->getMaxPlayers($l2);
                        //TODO: set sign text
                    }
                }
            }
        }
    }
}
