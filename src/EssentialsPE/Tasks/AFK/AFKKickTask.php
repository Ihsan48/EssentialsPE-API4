<?php

declare(strict_types = 1);

namespace EssentialsPE\Tasks\AFK;

use EssentialsPE\BaseFiles\BaseTask;
use EssentialsPE\BaseFiles\BaseAPI;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AFKKickTask extends BaseTask{
    /** @var Player  */
    protected $player;

    /**
     * @param BaseAPI $api
     * @param Player $player
     */
    public function __construct(BaseAPI $api, Player $player){
        parent::__construct($api);
        $this->player = $player;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick): void{
        // TODO: Remember access to API for tasks...
        $this->getAPI()->getServer()->getLogger()->debug(TextFormat::YELLOW . "Running EssentialsPE's AFKKickTask");
        if($this->player instanceof Player && $this->player->isOnline() && $this->getAPI()->isAFK($this->player) && !$this->player->hasPermission("essentials.afk.kickexempt") && time() - $this->getAPI()->getLastPlayerMovement($this->player) >= $this->getAPI()->getEssentialsPEPlugin()->getConfig()->getNested("afk.auto-set")){
            $this->player->kick("You have been kicked for idling more than " . (($time = floor($this->getAPI()->getEssentialsPEPlugin()->getConfig()->getNested("afk.auto-kick"))) / 60 >= 1 ? ($time / 60) . " minutes" : $time . " seconds"), false);
        }
    }
} 