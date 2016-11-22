<?php
namespace App\Repositories;

use App\Models\telegram\Bot;
use App\Models\upgiSystem\User;

class TelegramRepository
{

    public $bot;
    public $user;

    public function __construct(
        Bot $bot,
        User $user
    ) {
        $this->bot = $bot;
        $this->user = $user;
    }

    public function getUserTelegramID($erp_id)
    {
        $user = $this->user->where('mobileSystemAccount', $erp_id);
        if ($user->first()->exists()) 
        {
            $telegramID = $user->first()->telegramID;
            return $telegramID;
        }
        return null;
    }

    public function getBotData($bot) 
    {
        $data = $this->bot->where('username', $bot);
        return $data;
    }

    public function updateUserTelegramID($erpID, $telegramID) 
    {
        $user = $this->user->where('mobileSystemAccount', $erpID);
        if ($user->exists()) {
            $update = $user->update(['telegramID' => $telegramID]);
            return true;
        }
        return false;
    }

    public function checkUser($id) 
    {
        $user = $this->user->where('mobileSystemAccount', $id);
        if ($user->first() == null) {
            return false;
        }
        return true;
    }

    public function updateBotUpdateID($bot, $updateID) 
    {
        $update = $bot->update(['updateID' => $updateID]);
    }
}