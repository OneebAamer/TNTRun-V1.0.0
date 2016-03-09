<?php
namespace LittleBigMC\TNTRun;
use pocketmine\level\Position;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;

use LittleBigMC\TNTRun\Main;
class GameTask extends PluginTask
{
    private $pl;
    public function __construct(Main $Pl){
        parent::__construct($Pl);
        $this->pl = $Pl;
    }
    public function onRun($currentTick){
        $win = 0;
        if(count($this->pl->tntrun) <= 0){
            $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
            $this->pl->running = false;
            unset($this->pl->tntrun);
            unset($this->pl->cnt);
        }
        foreach($this->pl->cnt as $pl=>$count){
            if($win < $count){
                $win = $count;
            }
            if(isset($this->pl->tntrun[$pl])){
                foreach($this->pl->tntrun as $p){
                    $w = $this->pl->tntrun[$pl];
                    $this->pl->getServer()->broadcastMessage(TextFormat::GREEN."[TNTRun] Game is open.");
                    $w->teleport(new Position($this->pl->lx,$this->pl->ly,$this->pl->lz,$this->pl->llvl),0,0);
                    $this->pl->pay($w,$this->pl->amt,$this->pl->money);
                    $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
                    $p->sendMessage(TextFormat::GREEN."[TNTRun] ".$w->getName()." won the game!");
                    break;
                }
            }
            $this->pl->running = false;
            unset($this->pl->tntrun);
            unset($this->pl->cnt);
        }
    }
}