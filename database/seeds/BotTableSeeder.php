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
        ]);
    }
}
