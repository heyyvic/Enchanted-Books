<?php

namespace shadow\tasks;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\utils\TextFormat;
use shadow\enchantment\Enchantment;

class EnchantTasks extends Task
{
    private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(): void
    {
        if (!$this->player->isOnline() || $this->player->isClosed()) {
            return;
        }

        foreach ($this->player->getArmorInventory()->getContents() as $armor) {
            if ($armor === null) continue;
            foreach ($armor->getLore() as $lore) {
                $lore = TextFormat::clean($lore);
                if (str_contains($lore, 'Speed')) {
                    $this->player->getEffects()->add(new EffectInstance(VanillaEffects::SPEED(), 40, 1, false));
                }
                if (str_contains($lore, 'FireResistance')) {
                    $this->player->getEffects()->add(new EffectInstance(VanillaEffects::FIRE_RESISTANCE(), 40, 0, false));
                }
                if (str_contains($lore, 'Invisibility')) {
                    $this->player->getEffects()->add(new EffectInstance(VanillaEffects::INVISIBILITY(), 40, 0, false));
                }
                if (str_contains($lore, 'NightVision')) {
                    $this->player->getEffects()->add(new EffectInstance(VanillaEffects::NIGHT_VISION(), 40, 0, false));
                }
                if (str_contains($lore, 'HellForged')) {
                    $this->player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 40, 0, false));
                }
                if (str_contains($lore, 'Fury')) {
                    $this->player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 40, 0, false));
                }
            }
        }

        foreach ($this->player->getArmorInventory()->getContents() as $armor) {
            if ($armor === null) continue;
            foreach ($armor->getEnchantments() as $enchantment) {
                $type = $enchantment->getType();
                if ($type instanceof Enchantment) {
                    $type->giveEffect($this->player);
                }
            }
        }
    }
}