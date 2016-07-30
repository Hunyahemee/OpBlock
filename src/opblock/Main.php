<?php

namespace opblock;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listerner{

private $plogged;

     public function onLoad() {
         $this->getLogger->info(TextFormat::RED."[OpBlock] loading... ");
     }
     public function onEnable() {
                $this->getLogger()->info("[OpBlock] Enabled");
$this->cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->getLogger->info(TextFormat::GREEN."[OpBlock] OpBlock loaded!");
                $this->saveDefaultConfig();
                $this->list = $this->getConfig()->get('list');
}

public function onCommand(CommandSender $sender, Command $command, $label, array $args) {

if($command->getName() == opblock and $sender->hasPermission("opblock.command")){

    switch(strtolower($args[0])) {
    // add and remove player from bypass list
         case "add":
                if ($sender->hasPermission("opblock.command.add")) {

                   if (isset($args[1])) {
                        $this->addPlayerConfig($args[1]);
                        $sender->sendMessage("Added ".$args[1] ."to Bypass list");
                    } else {
                       $sender->sendMessage("Usage: /opblock add <player>");
         }
                       } else {
                       $sender->sendMessage(TextFormat::RED."You Don't have permission to use this command");
                       }
                       break;
                       
           case "remove":
           case "rm":
                   if($sender->hasPermission("opblock.command.rm")){
                      if (isset($args[1])) {
                           $this->removePlayerConfig($args[1]);
                           $sender->sendMessage("Removed ".$args[1] ."out of Bypass list");
                           }else{
                           $sender->sendMessage("Usage: /opblock remove <name>");
                        }
                     }   else {
                        $sender->sendMessage(TextFormat::RED."You don't have permission to use this command");
                        }
                      break;
                    
                      default:
                          $sender->sendMessage("Usage: /opblock <add/remove> or <password>");
                          break;
                       }
                       
                       $password = $this->getConfig()->get('password');
                       if ($sender instanceof Player) {
                          if (isset($args[0])) {
                             if ($args[0] == $password) {
                                $this->plogged[$event->getPlayer()->getName] == true;
                               $sender->sendMessage(TextFormat::GREEN."Password Accepted!");
                             } else {
                             $sender->sendMessage(TextFomat::RED."Wrong Password!");
                             }
                             } else {
                             $sender->sendMessage("Usage: /opblock <add/remove> or <password>");
                     }
                             } else {
                             $sender->sendMessage("This command is only avaliable for ingame player");
                             }
                        }
                   }
                                                                                       
public function onBlockBreak(BlockBreakEvent $event) {
$p = $event->getPlayer();
     if ($p->isOp()) {
          if(!$this->plogged[$event->getPlayer()->getName] == true){
              $p->sendMessage(TextFormat::RED."Please input Password for OP before you continute");
                    $event->setCancelled;
                    }
           }
}
                    
                    public function onTap(PlayerInteractEvent $event) {
                    $p = $event->getPlayer();
                    if ($p->isOp()) {
          if(!isset($this->plogged[$event->getPlayer()->getName] == true){
              $p->sendMessage(TextFormat::RED."Please input Password for OP before you continute");
                    $event->setCancelled;
                    }
            }
}
                    
               private function addPlayerConfig($event) {
               $playerName = $event->getPlayer()->getName();
            
                  $list = $this->getConfig()->get('list');
                  $new_list = $list;
                  $new_list[] = $playerName;
                  $this->getConfig()->set('list', $new_list);
                  $this->getConfig()->save();
                  $this->getConfig()->reload();
                  }
                  
                  private function removePlayerConfig($event) {
                  $playerName = $event->getPlayer()->getName();
             $list = $this->getConfig()->get('list'); 
             $for_remove = $playerName;
             $new_list = [];
                        foreach($list as $value) {
    if($value != $for_remove) {
        $new_list[] = $value;
    }
}
       $this->getConfig()->set('list', $new_list);
       $this->getConfig()->save();
       $this->getConfig()->reload();
             }
         
         public function onJoin(PlayerJoinEvent, $event) {
         $player = $event->getPlayer-();
         if ($player->isOp()){
        if ($this->list->exits($player->getName())) {
             $this->plogged[$player->getName] == true;
             }
             if(!$this->plogged[$player->getName] == true) {
              $player->sendMessage(TextFormat::RED."Please input password for OP before you continute");
              }
            }
         }
      }           
