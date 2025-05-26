<?php

namespace shadow\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use shadow\books\BookManager;

class RemoveSubCommand extends BaseSubCommand
{

    public function __construct()
    {
        parent::__construct('remove', 'Remove a book');
    }

    /**
     * @inheritDoc
     */
    protected function prepare(): void
    {
        $this->setPermission('books.admin');
        $this->registerArgument(0, new RawStringArgument('type'));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) return;

        $manager = BookManager::getInstance();
        $manager->removeBooks($args['type']);
        $sender->sendMessage('Book removed');;
    }
}