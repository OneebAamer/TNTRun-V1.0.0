<?php
namespace LittleBigMC\TNTRun;
use pocketmine\level\Position;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;

use LittleBigMC\TNTRun\Main;
class WaitTask extends PluginTask{

    private $pl;
    public function __construct(Main $Pl){
        parent::__construct($Pl);
        $this->pl = $Pl;
    }
    public function onRun($currentTick)
    {

        if(count($this->pl->tntrun) <= 0){
            $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
            $this->pl->running = false;
            unset($this->pl->tntrun);
            unset($this->pl->cnt);
        }
        foreach($this->pl->tntrun as $pl){
            $this->pl->createGameTask();
            $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
            $pl->teleport(new Position($this->pl->gx, $this->pl->gy, $this->pl->gz));
            $pl->sendMessage(TextFormat::GREEN."------------------------------------------\n".TextFormat::GOLD."[TNTRun] Game started, be the last survivor to win!\n".TextFormat::GREEN."------------------------------------------");
            break;
        }
    }
}