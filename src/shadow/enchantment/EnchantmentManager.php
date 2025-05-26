<?php

declare(strict_types=1);

namespace shadow\enchantment;

use shadow\commands\BookMenuCommand;
use shadow\commands\BooksCommand;
use shadow\Loader;
use shadow\enchantment\defaults\FireResistanceEnchantment;
use shadow\enchantment\defaults\FuryEnchantment;
use shadow\enchantment\defaults\GodEnchantment;
use shadow\enchantment\defaults\HellForgedEnchantment;
use shadow\enchantment\defaults\ImplantsEnchantment;
use shadow\enchantment\defaults\InvisibilityEnchantment;
use shadow\enchantment\defaults\NightVisionEnchantment;
use shadow\enchantment\defaults\SpeedEnchantment;
use shadow\enchantment\defaults\ZeusEnchantment;
use pocketmine\data\bedrock\EnchantmentIdMap;

/**
 * Class EnchantmentManager
 * @package shadow\enchantment
 */
class EnchantmentManager
{
    
    /** @var Enchantment[] */
    private array $enchantments = [];
    
    /**
     * EnchantmentManager construct.
     */
    public function __construct()
    {
        # Register custom enchants
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::SPEED, $this->enchantments[40] = new SpeedEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::INVISIBILITY, $this->enchantments[41] = new InvisibilityEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::NIGHT_VISION, $this->enchantments[42] = new NightVisionEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::FIRE_RESISTANCE, $this->enchantments[43] = new FireResistanceEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::IMPLANTS, $this->enchantments[44] = new ImplantsEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::HELLFORGED, $this->enchantments[45] = new HellForgedEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::ZEUS, $this->enchantments[46] = new ZeusEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::GOD, $this->enchantments[47] = new GodEnchantment());
        EnchantmentIdMap::getInstance()->register(EnchantmentIds::FURY, $this->enchantments[48] = new FuryEnchantment());

        Loader::getInstance()->getServer()->getCommandMap()->register('books', new BookMenuCommand());
        Loader::getInstance()->getServer()->getCommandMap()->register('books', new BooksCommand());
    }
    
    /**
     * @return Enchantment[]
     */
    public function getEnchantments(): array
    {
        return $this->enchantments;
    }
}