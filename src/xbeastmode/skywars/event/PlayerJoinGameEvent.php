<?php
namespace xbeastmode\skywars\event;
use pocketmine\event\Cancellable;
use pocketmine\Player;
use xbeastmode\skywars\game\SWGame;
use xbeastmode\skywars\Loader;
class PlayerJoinGameEvent extends SkyWarsEvent implements Cancellable{
    /** @var Player */
    private $p;
    /** @var SWGame */
    private $game;
    /**
     * @param Loader $loader
     * @param Player $p
     * @param $game
     */
    public function __construct(Loader $loader, Player $p, $game){
        parent::__construct($loader);
        $this->p = $p;
        $this->game = $game;
    }
    /**
     * @return Player
     */
    public function getPlayer(){
        return $this->p;
    }
    /**
     * @param Player $p
     */
    public function setPlayer(Player $p){
        $this->p = $p;
    }
    /**
     * @return SWGame
     */
    public function getGame(){
        return $this->game;
    }
    /**
     * @param $game
     */
    public function setGame($game){
        $this->game = (string)$game;
    }
}
