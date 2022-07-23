<?php

namespace lucky;

/*
LuckyBlocks GITHUB
By Correct88004216
*/

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;

class Main extends PluginBase implements Listener{
    public $moneylb;
    public $lbcount = 64; //How many lucky blocks are given per purchase
    public $buylbcount = 100; //How much can you buy a block of varnishes. Standard value - 100 stone

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("LuckyBlock-System started!");
    }

    public function isLB(){ //Is LuckyBlock
        return 188;
    }

    public function getMoneyLB(Player $player){
        return $this->moneylb[$player->getLowerCaseName()];
    }

    public function addMoneyLB(Player $player, $count){
        $count = $this->getMoneyLB($player) + $count;
        $this->moneylb[$player->getLowerCaseName()] = $count;
    }

    public function randomItem(Player $player){
        $inventory = $player->getInventory();
        $rdtype = mt_rand(1, 3);
        $rddata = mt_rand(0, 15);
        $rdcount = mt_rand(1, 64);
        $rdblock = mt_rand(1, 7);
        $rdarmor = mt_rand(1, 8);
        $rdsword = mt_rand(1, 3);
        if($rdtype == 1){
            if($rdblock == 1){
                $inventory->addItem(item::get(5, 0, $rdcount));
            }
            if($rdblock == 2){
                $inventory->addItem(item::get(1, 0, $rdcount));
            }
            if($rdblock == 3){
                $inventory->addItem(item::get(17, 0, $rdcount));
            }
            if($rdblock == 4){
                $inventory->addItem(item::get(35, $rddata, $rdcount));
            }
            if($rdblock == 5){
                $inventory->addItem(item::get(45, 0, $rdcount));
            }
            if($rdblock == 6){
                $inventory->addItem(item::get(24, 0, $rdcount));
            }
            if($rdblock == 7){
                $inventory->addItem(item::get(4, 0, $rdcount));
            }
        }
        if($rdtype == 2){
            if($rdarmor == 1){
                $inventory->addItem(item::get(302, 0, 1));
            }
            if($rdarmor == 2){
                $inventory->addItem(item::get(303, 0, 1));
            }
            if($rdarmor == 3){
                $inventory->addItem(item::get(304, 0, 1));
            }
            if($rdarmor == 4){
                $inventory->addItem(item::get(305, 0, 1));
            }
            if($rdarmor == 5){
                $inventory->addItem(item::get(310, 0, 1));
            }
            if($rdarmor == 6){
                $inventory->addItem(item::get(311, 0, 1));
            }
            if($rdarmor == 7){
                $inventory->addItem(item::get(312, 0, 1));
            }
            if($rdarmor == 8){
                $inventory->addItem(item::get(313, 0, 1));
            }
        }
        if($rdtype == 3){
            if($rdsword == 1){
                $inventory->addItem(item::get(268, 0, 1));
            }
            if($rdsword == 2){
                $inventory->addItem(item::get(272, 0, 1));
            }
            if($rdsword == 3){
                $inventory->addItem(item::get(276, 0, 1));
            }
        }
    }

    public function onBreakLuckyBlock(BlockBreakEvent $event){
        $player = $event->getPlayer();
        if($event->getBlock()->getId() == $this->isLB()){
            $this->randomItem($player);
        }
        if($event->getBlock()->getId() == 1 and !$player->getGamemode(1)){
            $this->addMoneyLB($player, 1); //Adding 1 stone
        }
    }
    
    public function onCommand(CommandSender $p, Command $cmd, $label, array $args) : bool {
        if($cmd->getName() == "buylb") {
            if($this->getMoneyLB($p) == $this->buylbcount) {
                $p->sendMessage("You bought 64 block lucky!");
                $this->addedLuckyBlock($this->lbcount);
                return true;
            }else{
                $p->sendMessage("You don't have a stone :(");
                return true;
            }
        }
        if($cmd->getName() == "mystone") {
            $p->sendMessage("You got the stone: {$this->getMoneyLB($p)}");
            return false;
        }
    }
}