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
        $return = [];
        if ($ok) {
            $lastID = $updateID;
            $result = $data->result;
            foreach ($result as $res) {
                $update_id = $res->update_id;
                $message = $res->message;
                $message_id = $message->message_id;
                $from_id = $message->from->id;
                $date = date('Y-m-d H:i:s', $message->date);
                $text = $message->text;

                if ($update_id > $updateID && $this->telegram->checkUser($text)) {
                    $erpID = $text;
                    $updateUser = $this->telegram->updateUserTelegramID($erpID, $from_id);

                    if (!$updateUser['success']) {
                        array_push($return, ['ok' => false, 'msg' => $updateUser['msg']]);
                        return $return;
                    }
                    
                    $array['erpID'] = $erpID;
                    $array['telegramID'] = $from_id;
                    array_push($updateData, $array);
                }
                $lastID = $update_id;
            }
            $updateBot = $this->telegram->updateBotUpdateID($botData, $lastID);
        }

        //發送申請成功訊息給使用者
        
        foreach ($updateData as $up) {
            $erpID = $up['erpID'];
            $telegramID = $up['telegramID'];
            $message = $erpID . urlencode(' 您已成功登錄[統義玻璃系統]');
            $result = $this->sendBotMessage($bot, $telegramID, $message);
            array_push($return, $result);
        }
        return $return;
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