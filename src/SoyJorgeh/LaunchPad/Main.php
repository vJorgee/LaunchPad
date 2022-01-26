<?php

namespace SoyJorgeh\LaunchPad;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

use pocketmine\math\Vector3;
use pocketmine\event\entity\EntityDammageEvent;

use pocketmine\world\particle\FlameParticle;
use pocketmine\world\sound\BlazeShootSound;

class Main extends PluginBase implements Listener{

    public function onEnable(): void {
        $this->getLogger()->info("The plugin turn ON");
    }

    public function onDisable(): void {
        $this->getLogger()->info("The plugin turn OFF");
    }

    public $noDammage = [];

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $world = $player->getWorld();
        $x = $player->getPosition()->getX();
        $y = $player->getPosition()->getY();
        $z = $player->getPosition()->getZ();
        $block = $player->getWorld()->getBlock(new Vector3($x, $y - 0.5, $z));
        if($block->getId() === 165){
            $this->$noDammage[$player->getName()] = $player->getName();
            $player->setMotion(new Vector3(0, 0.5, 0));
            $world->addParticle(new Vector3($x + 0.5, $y, $z), new FlameParticle($x + 0.5, $y, $z));
            $world->addParticle(new Vector3($x, $y, $z + 0.5), new FlameParticle($x, $y, $z + 0.5));
            $world->addParticle(new Vector3($x - 0.5, $y, $z), new FlameParticle($x - 0.5, $y, $z));
            $world->addParticle(new Vector3($x, $y, $z - 0.5), new FlameParticle($x, $y, $z - 0.5));
            $world->addSound(new Vector3($x, $y, $z), new BlazeShootSound($player));
        }
    }

    public function onDammage(EntityDammageEvent $event){
        if($event->getCause() == EntityDammageEvent::CAUSE_FALL){
            $event->cancel();
            unset($this->noDammage[$event->getEntity()->getName()]);
        }
    }

}