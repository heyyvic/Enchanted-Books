<?php

namespace shadow\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use shadow\books\BookManager;

class CreateSubCommand extends BaseSubCommand
{

    public function __construct()
    {
        parent::__construct('create', 'create a book enchant');
    }

    /**
     * @inheritDoc
     */
    protected function prepare(): void
    {
        $this->setPermission('books.admin');
        $this->registerArgument(0, new RawStringArgument('speed|fire|inv|hell|nigth|zeus|fury.'));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) return;

        $manager = BookManager::getInstance();
        $manager->createBooks($args['speed|fire|inv|hell|nigth|zeus|fury.']);
        $sender->sendMessage('Book created');;
    }
}