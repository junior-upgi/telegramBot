<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TelegramRepository;
use App\Service\TelegramService;

class TelegramController extends Controller
{
    //file_get_contents('url_here')

    public $telegram;
    public $service;

    public function __construct(
        TelegramRepository $telegram,
        TelegramService $service
    ) {
        $this->telegram = $telegram;
        $this->service = $service;
    }

    public function getUpdates($bot) 
    {
        $result = $this->service->botRegister($bot);
        return $result;
    }

    public function sendMessage($bot, $user, $message)
    {
        $telegramID = $this->telegram->getUserTelegramID($user); 
        $result = $this->service->sendBotMessage('testBot', $telegramID, $message);
        if ($result) {
            return 'success!!';
        }
        return 'fail!!';
    }
    public function getUserList()
    {
        $list = $this->service->getUserTelegramInfo();
        return view('user')->with('user', $list);
    }
}
