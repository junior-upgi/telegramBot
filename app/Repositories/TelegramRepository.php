<?php
namespace App\Repositories;

use App\Models\telegram\Bot;
use App\Models\upgiSystem\User;
use App\Models\DB_U105\PRDT;

class TelegramRepository
{

    public $bot;
    public $user;
    public $prd;

    public function __construct(
        Bot $bot,
        User $user,
        PRDT $prd
    ) {
        $this->bot = $bot;
        $this->user = $user;
        $this->prd = $prd;
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

    public function updateUserTelegramID($erpID, $params) 
    {
        $update = $this->updateUser($erpID,$params);
        return $update;
    }

    public function updateUserTelegramUserName($erpID, $username)
    {
        $params = ['telegramUserName' => $username];
        $update = $this->updateUser($erpID,$params);
        return $update;
    }

    private function updateUser($erpID, $params)
    {
        $user = $this->user->where('mobileSystemAccount', $erpID);
        if ($user->exists()) {
            $update = $user->update($params);
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

    public function getUserInfo()
    {
        $user = $this->user->where('telegramID', '<>', null)->with('staff')->get();
        return $user;
    }

    public function test()
    {
        try {
            $list = $this->prd->get();
            return [
                'success' => true,
                'msg' => count($list),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'msg' => $e,
            ];
        }
    }
}