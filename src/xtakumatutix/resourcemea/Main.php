<?php

namespace xtakumatutix\resourcemea;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\block\Air;
use pocketmine\Block\InvisibleBedrock;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getLogger()->notice("読み込み完了 - ver." . $this->getDescription()->getVersion());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onBreak(BlockBreakEvent $event)
    {
        $block = $event->getBlock();
        $y = $block->getFloorY() + 3;
        $Acquisition = new Vector3($block->getFloorX(), $y, $block->getFloorZ());
        if ($block->getLevel()->getName() == 'main') {
            $player = $event->getPlayer();
            if (!$player->isOP()) {
                if (!$block->getLevel()->getBlock($Acquisition) instanceof Air or !$block->getLevel()->getBlock($Acquisition) instanceof InvisibleBedrock) {
                    $player = $event->getPlayer();
                    $event->setCancelled();
                    $player->sendPopup('縦3マスで掘ってください');
                }
            }
        }
    }
}