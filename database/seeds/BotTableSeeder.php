<?php

use Illuminate\Database\Seeder;
use App\Models\telegram\Bot;

class BotTableSeeder extends Seeder
{
    public $bot;

    public function __construct(Bot $bot) {
        $this->bot = $bot;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->bot->insert([
            'name' => '@sparkTestBot',
            'token' => '260542039:AAEOxo0MbczouifWwQKDyIyJKBN6Iy43htk',
            'updateID' => '80741799',
        ]);

        $this->bot->insert([
            'name' => '@upgiRegisterBot',
            'token' => '296411532:AAF9U92K7LLKB7g-jvvG4remdHGi90ph2fI',
            'updateID' => '831723827',
        ]);
    }
}
