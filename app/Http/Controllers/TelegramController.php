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
}
