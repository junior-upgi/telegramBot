<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reponsitories\TelegramReponsitory;
use App\Service\TelegramService;

class TelegramController extends Controller
{
    //file_get_contents('url_here')

    public $telegram;
    public $service;

    public function __construct(
        TelegramReponsitory $telegram,
        TelegramService $service
    ) {
        $this->telegram = $telegram;
        $this->service = $service;
    }

    public function getUpdates($bot) {
        $result = $this->service->botRegister($bot);
        return $result;
    }
}
