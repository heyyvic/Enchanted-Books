<?php

namespace shadow\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use shadow\books\BookManager;

class ListSubCommand extends BaseSubCommand
{

    public function __construct()
    {
        parent::__construct('list', 'List all available books');
    }

    /**
     * @inheritDoc
     */
    protected function prepare(): void
    {
        $this->setPermission('books.admin');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) return;

        $sender->sendMessage(TextFormat::YELLOW.BookManager::getInstance()->getBooksList());
    }
}