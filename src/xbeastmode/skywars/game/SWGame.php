<?php
namespace xbeastmode\skywars\game;
use pocketmine\level\Position;
use xbeastmode\skywars\Loader;
class SWGame{
    /** @var Loader */
    public $plugin;
    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader){
        $this->plugin = $loader;
    }
    /**
     * @param $game
     * @return int
     */
    public function getWaitingTime($game){
        return intval($this->plugin->skyWarsConfig()->getAll()["SW_Games"][$game]["Waiting_Time"]);
    }
    /**
     * @param $game
     * @return int
     */
    public function getMinPlayers($game){
        return intval($this->plugin->skyWarsConfig()->getAll()["SW_Games"][$game]["Min_Players"]);
    }
    /**
     * @param $game
     * @return int
     */
    public function getMaxPlayers($game){
       return intval($this->plugin->skyWarsConfig()->getAll()["SW_Games"][$game]["Max_Players"]);
    }
    /**
     * @param $game
     * @return \pocketmine\level\Level
     */
    public function getGameLevel($game){
        $lvl = $this->plugin->skyWarsConfig()->getAll()["SW_Games"][$game]["Level"];
        $this->plugin->getServer()->loadLevel($lvl);
        $lvl = $this->plugin->getServer()->getLevelByName($lvl);
        return $lvl;
    }
    /**
     * @param $game
     * @return Position
     */
    public function getLobbyPos($game){
        $pos = $this->plugin->skyWarsConfig()->getAll()["SW_Games"][$game]["Lobby_Pos"];
        $pos = explode(":",$pos);
        $x = $pos[0];
        $y = $pos[1];
        $z = $pos[2];
        $level = $pos[3];
        $pos = new Position($x,$y,$z,$level);
        return $pos;
    }
    /**
     * @param $game
     * @return int
     */
    public function getNumberOfSlots($game){
        return count($this->plugin->skyWarsConfig()->getAll()["SW_Games"][$game]["Slots"]);
    }
}
