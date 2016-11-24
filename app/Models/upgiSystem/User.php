<?php

namespace App\Models\upgiSystem;

use Illuminate\Database\Eloquent\Model;

use App\Models\UPGWeb\StaffNode;

class User extends Model
{
    //
    protected $connection = 'upgiSystem';
    protected $table = "user";

    protected $fillable = [
        'ID',
        'mobileSystemAccount',
        'telegramID',
    ];

    public function staff()
    {
        return $this->hasOne(StaffNode::class, 'ID', 'erpID');
    }
}
