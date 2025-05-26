<?php

declare(strict_types=1);

namespace shadow\enchantment;

use pocketmine\player\Player;

/**
 * Class Enchantment
 * @package shadow\enchantment
 */
abstract class Enchantment extends \pocketmine\item\enchantment\Enchantment
{
    
    /**
     * @param Player $player
     */
    public function giveEffect(Player $player): void {}
    
    /**
     * @param Player $player
     */
    public function handleMove(Player $player): void {}
}
