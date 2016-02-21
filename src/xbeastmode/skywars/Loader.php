<?php
namespace xbeastmode\skywars;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use xbeastmode\skywars\tasks\TipTask;
class Loader extends PluginBase{
    /** @var Config */
    private $cfg;
    /** @var Config */
    private $msg;
    /** @var array */
    private $tasks = [];
    public function onEnable(){
        $messages =
            [
                "Game_Full" => "&cGame %game% is full. Please find a different one",
                "Game_Won" => "&a%player% won the game %game%!",
                "Joined_Game" => "&b%player% joined the game",
                "Left_Game" => "&c%player% left the game",
                "Waiting_Tip" => "&1> &aStarting soon &1<",
                "Time_Tip" => "&1> &aStarting in &7%minutes%:%seconds% &1<"
            ];
        $config =
            ["SW_Games" =>
                ["default" =>
                    ["Waiting_Time" => 60,//60 seconds
                     "Min_Players" => 2,
                     "Max_Players" => 8,
                     "Level" => "world",
                     "Lobby_Pos" => "99:99:99:world",//x:y:z:level
                     "Slots" =>
                         ["Slot1" => "99:99:99",//x:y:z
                          "Slot2" => "88:88:88"
                         ]
                    ]
                ]
            ];
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->cfg = new Config($this->getDataFolder()."SkyWars.yml", Config::YAML, $config);
        $this->msg = new Config($this->getDataFolder()."Messages.yml", Config::YAML, $messages);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
    /**
     * @return Config
     */
    public function skyWarsConfig(){
        return $this->cfg;
    }
    /**
     * @param $message
     * @return string
     */
    public function getMessage($message){
        return $this->msg->get($message);
    }
    /**
     * @return array
     */
    public function getTasks(){
        return $this->tasks;
    }
    public function makeTipTask($game){
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new TipTask($this, $game), 20);
    }
}
