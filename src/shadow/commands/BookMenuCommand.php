<?php

namespace shadow\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use shadow\menu\Menu;

class BookMenuCommand extends Command
{

    public function __construct()
    {
        parent::__construct('book', 'book menu command');
        $this->setPermission('books.perms');;
    }

    /**
     * @inheritDoc
     */
    public function execute(CommandSender $player, string $label, array $args)
    {
        if (!$player instanceof Player) return;

        Menu::send($player);
    }
}