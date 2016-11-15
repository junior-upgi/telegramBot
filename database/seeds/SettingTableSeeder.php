<?php

use Illuminate\Database\Seeder;
use App\Models\telegram\Setting;

class SettingTableSeeder extends Seeder
{
    public $setting;

    public function __construct(Setting $setting) {
        $this->setting = $setting;        
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->setting->insert([
            'settingCode' => 'bot_api_url',
            'value' => 'https://api.telegram.org/bot',
        ]);

    }
}
