<?php

namespace App\Models\telegram;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $connection = 'telegram';
    protected $table = "message";

    public function bot () {
        $result = $this->hasOne('App\Models\telegram\Bot', 'id', 'botID');
        return $result;
    }
}
