<?php

namespace SoyJorgeh\LaunchPad;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

use pocketmine\math\Vector3;
use pocketmine\event\entity\EntityDammageEvent;


class Main extends PluginBase implements Listener{

    public function onEnable(): void {
        $this->getLogger()->info("The plugin turn ON");
    }

    public function onDisable(): void {
        $this->getLogger()->info("The plugin turn OFF");
    }

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $x = $player->getPosition()->getX();
        $y = $player->getPosition()->getY();
        $z = $player->getPosition()->getZ();
        $block = $player->getWorld()->getBlock(new Vector3($x, $y - 0.5, $z));
        if($block->getId() === 165){
            $player->setMotion(new Vector3(0, 0.5, 0));
        }
    }

}