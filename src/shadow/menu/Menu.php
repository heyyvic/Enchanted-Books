<?php

namespace shadow\menu;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\StringTag;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use shadow\books\BookManager;

class Menu
{
    public static function send(Player $player): void
    {
        $menu = InvMenu::create(InvMenu::TYPE_CHEST);

        $bookManager = BookManager::getInstance();
        foreach ($bookManager->getAllBooks() as $book) {
            $item = VanillaItems::ENCHANTED_BOOK();
            $item->setCustomName(TextFormat::colorize('§4Book Enchant'));
            $item->setLore([TextFormat::colorize('§g' . $book->getLore())]);
            $item->getNamedTag()->setTag('books', new StringTag($book->getType()));
            $menu->getInventory()->addItem($item);
        }

        $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
            $player = $transaction->getPlayer();
            $item = $transaction->getItemClicked();
            $bookType = $item->getNamedTag()->getString('books', '');

            $bookManager = BookManager::getInstance();
            $book = $bookManager->getBooks($bookType);

            if ($book !== null) {
                $item = VanillaItems::ENCHANTED_BOOK();
                $item->setCustomName(TextFormat::colorize('§4Book Enchant'));
                $item->setLore([TextFormat::colorize('§g' . $book->getLore())]);
                $item->getNamedTag()->setTag('books', new StringTag($book->getType()));
                $player->getInventory()->addItem($item);
            } else {
                $player->sendMessage(TextFormat::RED . "shadow enchantment book");
            }
            return $transaction->discard();
        });
        $menu->send($player, TextFormat::DARK_RED . " Enchantment Books");
    }
}