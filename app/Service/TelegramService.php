<?php
namespace App\Service;

use App\Repositories\TelegramRepository;

class TelegramService 
{
    public $telegram;

    public function __construct(TelegramRepository $telegram) 
    {
        $this->telegram = $telegram;
    }

    public function botRegister($bot) 
    {
        $botData = $this->telegram->getBotData($bot);
        $token = $botData->first()->token;
        $updateID = $botData->first()->updateID;
        $url = $this->telegram->getSettingValue('bot_api_url');
        $data = json_decode(file_get_contents($url . $token . "/getUpdates"));
        $ok = $data->ok;
        $lastID = '';
        $updateData = [];
        $logs = [];
        if ($ok) {
            $lastID = $updateID;
            $result = $data->result;
            foreach ($result as $res) {
                $register = $this->userRegister($res, $updateID);
                if (isset($register)) {
                    $log['msg'] = $register['erpID'] . ': ' . $register['msg'] . ' ' . $register['telegramID'];  
                    array_push($logs, $log);
                }
                if ($register['success']) {
                    $erpID = $register['erpID'];
                    $telegramID =  $register['telegramID'];
                    $message = $erpID . ' 您已成功登錄[統義玻璃系統]';
                    $send = $this->sendBotMessage($bot, $telegramID, $message);
                    if ($send->ok) {
                        $log['msg'] = $erpID . ': 發送通知成功!';
                    } else {
                        $log['msg'] = $erpID . ': 發送通知失敗!';
                    }
                    array_push($logs, $log);
                }
                $lastID = $res->update_id;
            }
            $updateBot = $this->telegram->updateBotUpdateID($botData, $lastID);
        }
        return $logs;
    }

    private function userRegister($res, $updateID)
    {
        $update_id = $res->update_id;
        $message = $res->message;
        $telegramID = $message->from->id;
        $text = $message->text;

        if ($update_id > $updateID) {
            $erpID = $text;
            $updateUser = $this->telegram->updateUserTelegramID($erpID, $telegramID);

            if ($updateUser) {
                return [
                    'success' => true,
                    'msg' => '註冊成功',
                    'erpID' => $erpID,
                    'telegramID' => $telegramID,
                ];
            } else {
                return [
                    'success' => false,
                    'msg' => '註冊失敗',
                    'erpID' => $erpID,
                    'telegramID' => $telegramID,
                ];
            }
        }
    }

    public function sendBotMessage($bot, $telegramID, $message) 
    {
        $url = $this->telegram->getSettingValue('bot_api_url');
        $botData = $this->telegram->getBotData($bot);
        $token = $botData->first()->token;
        $method = '/sendMessage';
        $sendUrl = $url . $token . $method . '?chat_id=' . $telegramID . '&text=' . $message;
        $send = json_decode(file_get_contents($sendUrl));
        return $send;
    }
}