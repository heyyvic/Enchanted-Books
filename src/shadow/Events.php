<?php

namespace shadow;

use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\Armor;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\TextFormat;
use shadow\books\BookManager;
use shadow\tasks\EnchantTasks;

class Events implements Listener
{
    public function onTransaction(InventoryTransactionEvent $event): void
    {
        $transaction = $event->getTransaction();
        $player = $transaction->getSource();

        foreach ($transaction->getActions() as $action) {
            if (!$action instanceof SlotChangeAction) continue;

            $sourceItem = $action->getSourceItem();
            $targetItem = $action->getTargetItem();

            if (
                $sourceItem->getTypeId() === ItemTypeIds::ENCHANTED_BOOK &&
                $sourceItem->getNamedTag()->getTag('books') instanceof StringTag &&
                $targetItem instanceof Armor
            ) {
                $bookType = $sourceItem->getNamedTag()->getString('books', '');
                $bookManager = BookManager::getInstance();
                $book = $bookManager?->getBooks($bookType);

                if ($book === null) {
                    $player->sendMessage(TextFormat::colorize('&cshadow enchantment book'));
                    $event->cancel();
                    return;
                }

                $lore = $targetItem->getLore();
                $newLore = TextFormat::colorize('§g' . $book->getLore());

                if (in_array($newLore, $lore)) {
                    $player->sendMessage(TextFormat::colorize('&cThe item already contains this enchantment'));
                    $event->cancel();
                    return;
                }

                $lore[] = $newLore;
                $targetItem->setLore($lore);

                $event->cancel();

                $action->getInventory()->setItem($action->getSlot(), $targetItem);

                $newBook = clone $sourceItem;
                $newBook->setCount($sourceItem->getCount() - 1);
                if ($newBook->getCount() > 0) {
                    $player->getInventory()->setItemInHand($newBook);
                } else {
                    $player->getInventory()->setItemInHand(VanillaItems::AIR());
                }

                $player->sendMessage(TextFormat::colorize('&aYou have successfully enchanted the item'));
                return;
            }
        }
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new EnchantTasks($player), 20);
    }
}