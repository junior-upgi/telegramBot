<?php
namespace App\Repositories;

use App\Models\telegram\Bot;
use App\Models\telegram\Message;
use App\Models\telegram\Setting;
use App\Models\upgiSystem\User;

class TelegramRepository
{

    public $bot;
    public $message;
    public $setting;
    public $user;

    public function __construct(
        Bot $bot,
        Message $message,
        Setting $setting,
        User $user
    ) {
        $this->bot = $bot;
        $this->message = $message;
        $this->setting = $setting;
        $this->user = $user;
    }

    public function getBotData($bot) 
    {
        $data = $this->bot->where('name', $bot);
        return $data;
    }

    public function getSettingValue($setting) 
    {
        $value = $this->setting->where('settingCode', $setting)->first()->value;
        return $value;
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