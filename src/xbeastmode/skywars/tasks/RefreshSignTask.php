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
                    $s3 = FMT::b($t->getText()[0]);
                    $s2 = FMT::b($t->getText()[1]);
                    $s1 = FMT::b($this->plugin->getConfig()->get("sw_sign_line_1"));
                    if(strtolower($s3) === strtolower($s1) and isset($this->plugin->skyWarsConfig()->getAll()[$s2])) {
                        $l1 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_1"));
                        $l2 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_2"));
                        $l3 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_3"));
                        $l4 = FMT::colorMessage($this->plugin->getConfig()->get("sw_sign_line_4"));
                        $sw = new SWManagement($this->plugin);
                        $count = null;
                        $max = (new SWGame($this->plugin))->getMaxPlayers($s2);
                        $status = $sw->getStatus($s2);
                        if(isset($sw->getPlayers()[$s2])){
                            $count = count((new SWManagement($this->plugin))->getPlayers()[$s2]);
                        }else{
                            $count = 0;
                        }
                        $t->setText($l1, str_replace("%game%", $s2, $l2),
                            str_replace(["%count%", "%max%"], [$count, $max], $l3), str_replace("%status%", $status, $l4));
                    }
                }
            }
        }
    }
}
