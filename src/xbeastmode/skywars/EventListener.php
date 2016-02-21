<?php
namespace xbeastmode\skywars;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\tile\Sign;
use xbeastmode\skywars\game\SWManagement;
use xbeastmode\skywars\utils\FMT;
class EventListener implements Listener{
    /** @var Loader */
    private $plugin;
    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader){
        $this->plugin = $loader;
    }
    /**
     * @param SignChangeEvent $e
     */
    public function onSignChange(SignChangeEvent $e){
        $l = $e->getLines();
        $p = $e->getPlayer();
        if($p->isOp() or $p->hasPermission("sw.sign.create")){
            if(strtolower($l[0]) === "skywars" and isset($this->plugin->skyWarsConfig()->getAll()[$l[1]])){
                $p->sendMessage(FMT::colorMessage("&aSuccessfully created game sign for game '&f".$l[1]."&a'!"));
            }elseif(strtolower($l[0]) === "skywars" and !isset($this->plugin->skyWarsConfig()->getAll()[$l[1]])){
                $p->sendMessage(FMT::colorMessage("&cError: game does not exist."));
            }
        }
    }
    /**
     * @param PlayerInteractEvent $e
     */
    public function onInteract(PlayerInteractEvent $e){
        $sign = $e->getBlock()->getLevel()->getTile($e->getBlock());
        $p = $e->getPlayer();
        if($sign instanceof Sign){
            $l = $sign->getText();
            $game = FMT::b($l[1]);
            if(strtolower($game) === "skywars" and isset($this->plugin->skyWarsConfig()->getAll()[$game])){
                $sw = new SWManagement($this->plugin);
                $sw->tpToOpenSlot($p, $game);
                $msg = $this->plugin->getMessage("Joined_Game");
                $sw->broadcastMessage($game, str_replace("%player%", $p->getName(), $msg));
            }
        }
    }
    /**
     * @param PlayerMoveEvent $e
     */
    public function onMove(PlayerMoveEvent $e){
        $p = $e->getPlayer();
        $sw = new SWManagement($this->plugin);
        foreach($sw->getPlayers() as $gm){
            if(isset($gm[spl_object_hash($p)])){
                $from = clone $e->getFrom();
                $to = $e->getTo();
                $from->yaw = $to->yaw;
                $from->pitch = $to->pitch;
                $e->setTo($from);
            }
        }
    }
}
