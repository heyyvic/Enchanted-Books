<?php

declare(strict_types=1);

namespace shadow\enchantment\defaults;

use shadow\enchantment\Enchantment;

use pocketmine\item\enchantment\ItemFlags;
use pocketmine\item\enchantment\Rarity;
use pocketmine\player\Player;

/**
 * Class ImplantsEnchantment
 * @package shadow\enchantment\defaults
 */
class ImplantsEnchantment extends Enchantment
{
    
    private $durationTicks = 0;

    /**
     * ImplantsEnchantment construct.
     */
    public function __construct()
    {
        parent::__construct('Implants', Rarity::COMMON, ItemFlags::ARMOR, ItemFlags::NONE, 5);
    }
    
    /**
	 * @param Player $player
	 */
    public function handleMove(Player $player): void
    {
        if ($player->getHungerManager()->getFood() < $player->getHungerManager()->getMaxFood())
            $player->getHungerManager()->setFood($player->getHungerManager()->getMaxFood());
    }
}