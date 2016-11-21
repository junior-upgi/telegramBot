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
            'updateID' => '831723842',
        ]);

        $this->bot->insert([
            'name' => '@productDevelopmentBot',
            'token' => '278943684:AAHQDQMZrI2_3jPKnrY8tdrhn-2mKN9CwpI',
            'updateID' => '0',
        ]);


        //joinedGroupIDList: [telegramChatGroup.list[1].id]
        $this->bot->insert([
            'name' => '@seedCountBot',
            'token' => '251686312:AAG8_sczOJvJSwtese4kgzH95RLyX5ZJ114',
            'updateID' => '0',
        ]);

        //joinedGroupIDList: [telegramChatGroup.list[0].id]
        $this->bot->insert([
            'name' => '@overdueMonitorBot',
            'token' => '267738010:AAGT17aLumIfVPNeFWht8eUEPuC2HfAouGk',
            'updateID' => '0',
        ]);
    }
}
