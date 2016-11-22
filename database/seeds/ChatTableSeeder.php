<?php

use Illuminate\Database\Seeder;

use Models\telegram\Chat;

class ChatTableSeeder extends Seeder
{
    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*
        -164742782	group	產品開發群組
        -162201704	group	測試群組
        -157638300	group	資訊群組
        -155069392	group	玻璃製造群組
        -150874076	group	業務群組
        */


        $this->bot->insert([
            'id' => '-164742782',
            'type' => 'group',
            'title' => '產品開發群組',
        ]);

        $this->bot->insert([
            'id' => '-162201704',
            'type' => 'group',
            'title' => '測試群組',
        ]);

        $this->bot->insert([
            'id' => '-157638300',
            'type' => 'group',
            'title' => '資訊群組',
        ]);

        $this->bot->insert([
            'id' => '-155069392',
            'type' => 'group',
            'title' => '玻璃製造群組',
        ]);

        $this->bot->insert([
            'id' => '-150874076',
            'type' => 'group',
            'title' => '業務群組',
        ]);

    }
}
