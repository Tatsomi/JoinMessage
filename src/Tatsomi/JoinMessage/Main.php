<?php

declare(strict_types = 1);

namespace Tatsomi\JoinMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    private Config $config;

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->notice("Plugin Has Enabled!");

        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function getJoinMessage(): string {
        return $this->config->get("JoinMessage");
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer()->getName();
        $message = str_replace('{player}', $player, $this->getJoinMessage());

        if ($message == null) {
            $this->getLogger()->warning("JoinMessage is empty!");
            return;
        }

        $event->setJoinMessage($message);
    }

    public function onDisable(): void {
        $this->getLogger()->notice("Plugin Has Disabled!");
    }
}
