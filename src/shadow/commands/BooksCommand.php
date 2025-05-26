<?php

namespace shadow\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use shadow\commands\subcommands\CreateSubCommand;
use shadow\commands\subcommands\ListSubCommand;
use shadow\commands\subcommands\RemoveSubCommand;
use shadow\Loader;

class BooksCommand extends BaseCommand
{

    public function __construct()
    {
        parent::__construct(
            Loader::getInstance(),
            'books',
            'Manage books',
        );
    }

    /**
     * @inheritDoc
     */
    protected function prepare(): void
    {
        $this->setPermission('books.perms');
        $this->registerSubCommand(new CreateSubCommand());
        $this->registerSubCommand(new RemoveSubCommand());
        $this->registerSubCommand(new ListSubCommand());
    }

    /**
     * @inheritDoc
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $msg = "&l&6Books Command";
        $msg .= "&r&7Use /books create <type> to create a book";
        $msg .= "&r&7Use /books remove <type> to remove a book";
        $msg .= "&r&7Use /books list to list all available books";
        $sender->sendMessage(TextFormat::colorize($msg));
    }

    public function getPermission()
    {
        return "books.perms";
    }
}