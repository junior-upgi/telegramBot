<?php

namespace App\Models\telegram;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    //
    protected $connection = 'telegram';
    protected $table = "bot";

    protected $fillable = [
        'name',
        'token',
        'updateID'
    ];

    public function message () 
    {
        $result = $this->hasOne('App\Models\telegram\Message', 'botID', 'id');
        return $result;
    }
}
