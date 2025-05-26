<?php

namespace shadow;

use muqsit\invmenu\InvMenuHandler;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use shadow\books\BookManager;
use shadow\commands\BookMenuCommand;
use shadow\enchantment\EnchantmentManager;

class Loader extends PluginBase
{
    use SingletonTrait;
    private EnchantmentManager $enchantmentManager;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        if (!InvMenuHandler::isRegistered()) {InvMenuHandler::register($this);}

        $this->enchantmentManager = new EnchantmentManager();

        new BookManager();
        BookManager::getInstance()->load();
        $this->getServer()->getPluginManager()->registerEvents(new Events(), $this);
        $this->getServer()->getCommandMap()->register('books', new BookMenuCommand());
    }

    public function books(string $type = 'inv'): array
    {
        $SpeedBook = VanillaItems::ENCHANTED_BOOK();
        $SpeedBook->setCustomName(TextFormat::DARK_RED . "Book Enchant");
        $SpeedBook->setLore([TextFormat::colorize('§gSpeed')]);
        $SpeedBook->getNamedTag()->setString('books', 'speed');

        $FireBook = VanillaItems::ENCHANTED_BOOK();
        $FireBook->setCustomName(TextFormat::DARK_RED . "Book Enchant");
        $FireBook->setLore([TextFormat::colorize('§gFire Resistance I')]);
        $FireBook->getNamedTag()->setString('books', 'fire');

        $InviBook = VanillaItems::ENCHANTED_BOOK();
        $InviBook->setCustomName(TextFormat::DARK_RED . "Book Enchant");
        $InviBook->setLore([TextFormat::colorize('§gInvisibility')]);
        $InviBook->getNamedTag()->setString('books', 'invi');

        $HellBook = VanillaItems::ENCHANTED_BOOK();
        $HellBook->setCustomName(TextFormat::DARK_RED . "Book Enchant");
        $HellBook->setLore([TextFormat::colorize('§gHell Forged')]);
        $HellBook->getNamedTag()->setString('books', 'hell');

        if ($type === 'inv') {
            return [
                'items' => [
                    'speed' => ['number' => 10, 'item' => $SpeedBook],
                    'fire' => ['number' => 11, 'item' => $FireBook],
                    'invi' => ['number' => 12, 'item' => $InviBook],
                    'hell' => ['number' => 13, 'item' => $HellBook],
                ]
            ];
        } elseif ($type === 'player') {
            return [
                'speed' => $SpeedBook,
                'fire' => $FireBook,
                'invi' => $InviBook,
                'hell' => $HellBook,
            ];
        }else{
            return [];
        }
    }

    /**
     * @return EnchantmentManager
     */
    public function getEnchantmentManager(): EnchantmentManager
    {
        return $this->enchantmentManager;
    }
}