<?php
namespace PalkiaDude\DeadEnd;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\level\Position;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

     public function onEnable(){
     $this->saveResource("config.yml");
        $yml = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->yml = $yml->getAll();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "Dead-End Minigame by PalkiaDude!");
        }
        
        public function onCommand(CommandSender $sender, Command $command, $commandLabel, array $args){
   if(strtolower($command->getName()) === "tntrun"){
   if($args[0] === "join"){
        $sender->teleport(new Position($this->yml["XYZ"]));
    }
    return true;
 }
}
     public function onPlayerMove(PlayerMoveEvent $event){
     $player = $event->getPlayer();
        $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
        $level = $player->getLevel();
        $pos = new Vector3($player->getFloorX(), $player->getFloorY() - 1, $player->getFloorZ()); 
     if($block->getId() === $this->yml["ID"]){
            $level->setBlock($pos, Block::get(BLOCK::AIR));
        }
        }
        }
