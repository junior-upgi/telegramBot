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
        //$url = $this->telegram->getSettingValue('bot_api_url');
        $url = 'https://api.telegram.org/bot';
        $data = $this->curlReturnJson($url . $token . "/getUpdates");
        //$data = json_decode(file_get_contents($url . $token . "/getUpdates"));
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
        $username = $message->from->username;
        $text = $message->text;

        if ($update_id > $updateID) {
            $erpID = $text;
            $params = ['telegramID' => $telegramID, 'telegramUserName' => $username];
            $updateUser = $this->telegram->updateUserTelegramID($erpID, $params);

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
        //$url = $this->telegram->getSettingValue('bot_api_url');
        $url = 'https://api.telegram.org/bot';
        $botData = $this->telegram->getBotData($bot);
        $token = $botData->first()->token;
        $method = '/sendMessage';
        $sendUrl = $url . $token . $method . '?chat_id=' . $telegramID . '&text=' . $message;
        $send = $this->curlReturnJson($sendUrl);
        return $send;
    }

    public function getUserTelegramInfo()
    {
        $url = 'https://api.telegram.org/bot296411532:AAF9U92K7LLKB7g-jvvG4remdHGi90ph2fI/getChat?chat_id=';
        $user = $this->telegram->getUserInfo();
        $list = [];
        foreach ($user as $info) {
            $set = [];
            $set['ID'] = $info->staff->ID;
            $set['name'] = $info->staff->name;
            $set['telegramID'] = $info->telegramID;
            $set['username'] = $info->telegramUserName;
            if ($info->telegramUserName == null) {
                $get = $this->curlReturnJson($url . $set['telegramID']);
                if ($get->ok) {
                    $set['username'] = $get->result->username;
                    $this->telegram->updateUserTelegramUserName($set['ID'], $set['username']);
                }
            }
            array_push($list, $set);
        }
        return $list;
    }

    private function curlReturnJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $get = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($get);
        return $json;
    }

    public function systemLook()
    {
        try {
            $botData = $this->telegram->getBotData('testBot');
            $token = $botData->first()->token;
            return ' system check true!';
        } catch (\Exception $e) {
            return ' system check fail!';
        }
        
    }

    public function test()
    {
        $test =  $this->telegram->test();
        return $test;
    }   
}