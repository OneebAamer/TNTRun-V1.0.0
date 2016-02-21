<?php
namespace xbeastmode\skywars\game;
use pocketmine\level\Position;
use pocketmine\Player;
use xbeastmode\skywars\event\PlayerJoinGameEvent;
use xbeastmode\skywars\utils\FMT;
class SWManagement extends SWGame{
    /** @var array */
    private $counters = [];
    /** @var array */
    private $players = [];
    /** @var array */
    private $status = [];
    /**
     * @return array
     */
    public function getCounters(){
        return $this->counters;
    }
    /**
     * @return array
     */
    public function getPlayers(){
        return $this->players;
    }
    /**
     * @param $game
     * @param $message
     */
    public function broadcastMessage($game, $message){
        foreach($this->players[$game] as $p){
            if($p instanceof Player){
                $p->sendMessage($message);
                break;
            }
        }
    }
    /**
     * @param $game
     * @return string
     */
    public function getStatus($game){
        return $this->status[$game];
    }
    /**
     * @param $game
     * @param $status
     */
    public function setStatus($game, $status){
        $this->status[$game] = (string)$status;
    }
    /**
     * @param Player $p
     * @param $game
     */
    public function tpToOpenSlot(Player $p, $game){
        if(!isset($this->counters[$game])) {
            $this->counters[$game] = $this->getNumberOfSlots($game) - 1;
        }
        if($this->counters[$game] <= -1){
            $msg = FMT::colorMessage($this->plugin->getMessage("Game_Full_Message"));
            $p->sendMessage(str_replace("%game%", $game, $msg));
            return;
        }
        $slot = $this->plugin->skyWarsConfig()->getAll()["SW_Games"][$game]["Slots"]["Slot".$this->counters[$game]];
        $pos = explode(":",$slot);
        $x = $pos[0];
        $y = $pos[1];
        $z = $pos[2];
        $level = $this->getGameLevel($game);
        $p->teleport(new Position($x,$y,$z,$level),0,0);
        $this->counters[$game] -= 1;
        $join = new PlayerJoinGameEvent($this->plugin, $p, $game);
        $this->plugin->getServer()->getPluginManager()->callEvent($join);
        $this->players[$game][spl_object_hash($p)] = $p;
        if(count($this->players[$game]) >= $this->getMinPlayers($game)){
            $this->status[$game] = "waiting";
        }else{
            $this->plugin->makeTipTask($game);
            $this->status[$game] = "waiting";
        }
    }
}
