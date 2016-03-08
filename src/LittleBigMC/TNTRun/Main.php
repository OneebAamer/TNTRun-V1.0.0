<?php
namespace LittleBigMC\TNTRun;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
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

use LittleBigMC\TNTRun\WaitTask;
use LittleBigMC\TNTRun\GameTask;

Class Main extends PluginBase implements Listener {
       public $gx;
       public $gy;
       public $gz;
       public $lx;
       public $ly;
       public $lz;
       public $running = false;
       
     public function onEnable(){
            @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->reloadConfig();
     $this->gx = $this->getConfig()->get("gx");
     $this->gy = $this->getConfig()->get("gy");
     $this->gz = $this->getConfig()->get("gz");
     $this->lx = $this->getConfig()->get("lx");
     $this->ly = $this->getConfig()->get("ly");
     $this->lz = $this->getConfig()->get("lz");
$this->saveResource("config.yml");
        $yml = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->yml = $yml->getAll();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "TNTRun by LittleBigMC loaded ;D!");
        }
     public function onPlayerMove(PlayerMoveEvent $event){
     $player = $event->getPlayer();
        $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
        $level = $player->getLevel();
        $pos = new Vector3($player->getFloorX(), $player->getFloorY() - 1, $player->getFloorZ()); 
     if($block->getId() === $this->yml["Block1"]){
            $level->setBlock($pos, Block::get($this->yml["Block2"]));
            }elseif($block->getId() === $this->yml["Block2"]){
            $level->setBlock($pos, Block::get($this->yml["Block3"]));
            }elseif($block->getId() === $this->yml["Block3"]){
            $level->setBlock($pos, Block::get(BLOCK::AIR));
        }elseif($block->getId() === 8){
        $player->teleport(new Position($this->pl->lx,$this->pl->ly,$this->pl->lz));
        $player->sendMessage("§e[TNTRun]§cBetter luck next time");
        if(isset($this->tntrun[$player->getName()])){
            unset($this->tnrun[$player->getName()]);
            unset($this->cnt[$player->getName()]);
            if(count($this->tntrun) <= 0){
                $this->getServer()->broadcastMessage(TextFormat::GREEN."[TNTRun] Game is open.");
                $this->running = false;
                unset($this->tntrun);
                unset($this->cnt);
            }
        }
}elseif($block->getId() === 9){
        $player->teleport(new Position($this->pl->lx,$this->pl->ly,$this->pl->lz));
        $player->sendMessage("§e[TNTRun]§cBetter luck next time");
        if(isset($this->tntrun[$player->getName()])){
            unset($this->tnrun[$player->getName()]);
            unset($this->cnt[$player->getName()]);
            if(count($this->tntrun) <= 0){
                $this->getServer()->broadcastMessage(TextFormat::GREEN."[TNTRun] Game is open.");
                $this->running = false;
                unset($this->tntrun);
                unset($this->cnt);
            }
        }
}
        }
          public function createGameTask(){
        $this->running = true;
        $t = new GameTask($this);
        $h = $this->getServer()->getScheduler()->scheduleDelayedTask($t, 20*$this->yml["game_time"]);
        $t->setHandler($h);
    }
       public function onCommand(CommandSender $runner, Command $call, $alia, array $arg){
        switch(strtolower($call->getName())){
            case 'tntrun':
                if(empty($arg) && $runner instanceof Player)$runner->sendMessage(TextFormat::RED."Usage: /tntrun <join|quit>");
                if($runner->hasPermission("tntrun.cmd") && $runner instanceof Player && isset($arg[0])){
                    switch(strtolower($arg[0])){
                        case 'join':
                            if(!isset($this->tntrun[$runner->getName()])) {
                                $this->cnt[$runner->getName()] = 0;
                                $this->tntrun[$runner->getName()] = $runner;
                                $runner->teleport(new Position($this->yml["wx"],$this->yml["wy"],$this->yml["wz"]));
                                foreach($this->tntrun as $pl){
                                    $pl->sendMessage(TextFormat::GOLD."[TNTRun] ".$runner->getName()." joined the match.");
                                    }
                            }else{
                                $runner->sendMessage(TextFormat::RED."[TNTrun] You already joined.");
                            }
		 if(count($this->tntrun) >= 1){

$wt = $this->yml["wait_time"];                                
$t = new WaitTask($this);
                                    $h = $this->getServer()->getScheduler()->scheduleDelayedTask($t, 20* $wt);
                                    $t->setHandler($h);
                                    foreach($this->tntrun as $pl) {
                                        $min = $this->yml["wait_time"]/60;
                                        $pl->sendMessage(TextFormat::GOLD."[TNTRun] Game starting in ".($this->yml["wait_time"] <= 60 ? "{$this->yml["wait_time"]} seconds" : "{$min} minutes."));
                                        break;
                                    }                            
                            if(count($this->tntrun) >= $this->yml["maxplayers"]){
                                $runner->sendMessage(TextFormat::RED."[TNTRun] Game full.");
                            }
                        break;
}
              
                        case 'quit':
                            if(isset($this->tntrun[$runner->getName()])){
                                $runner->teleport(new Position($this->yml["lx"],$this->yml["ly"],$this->yml["lz"]));
                                $runner->sendMessage(TextFormat::GREEN."[TNTRun] Teleporting...");
                                unset($this->tntrun[$runner->getName()]);
                                unset($this->cnt[$runner->getName()]);
                                if(count($this->tntrun) <= 0){
                                    $this->getServer()->broadcastMessage(TextFormat::GREEN."[TNTRun] Game is open.");
                                    $this->running = false;
                                    unset($this->tntrun);
                                    unset($this->cnt);
                                }
                            }
                        break;
                    }
                }
            break;
        }
    }
    public function onQuit(PlayerQuitEvent $e){
        $p = $e->getPlayer();
        if(isset($this->tntrun[$p->getName()])){
            unset($this->tntrun[$p->getName()]);
            unset($this->cnt[$p->getName()]);
            if(count($this->tntrun) <= 0){
                $this->getServer()->broadcastMessage(TextFormat::GREEN."[TNTRun] Game is open.");
                $this->running = false;
                unset($this->tntrun);
                unset($this->cnt);
            }
        }
    }
    public function onDeath(PlayerDeathEvent $e){
        $p = $e->getPlayer();
        if(isset($this->tntrun[$p->getName()])){
            unset($this->tntrun[$p->getName()]);
            unset($this->cnt[$p->getName()]);
            if(count($this->tntrun) <= 0){
                $this->getServer()->broadcastMessage(TextFormat::GREEN."[TNTRun] Game is open.");
                $this->running = false;
                unset($this->tntrun);
                unset($this->cnt);
        }
     }
   }
}
