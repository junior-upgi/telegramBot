<?php
/**
 * 每分鐘檢查登入申請訊息
 *
 * @version 1.0.0
 * @author spark it@upgi.com.tw
 * @date 16/10/14
 * @since 1.0.0 spark: 於此版本開始編寫註解
*/
namespace App\Console;

use Illuminate\Console\Command;
use File;
use App\Service\TelegramService;

/**
 * Class RegisterConsole
 *
 * @package App\Console
*/
class RegisterConsole extends Command
{
    /** @var string 命令名稱 */
    protected $signature = 'register';
    /** @var string 命令描述 */
    protected $description = '每分鐘檢查註冊';
    /** @var TelegramService */
    private $telegram;

    /**
     * 建構式
     *
     * @param ProjectCheckService $check
     * @return void
    */
    public function __construct(TelegramService $telegram)
    {
        parent::__construct();
        $this->telegram = $telegram;
    }

    /**
     * 執行命令
     *
     * @return void
    */
    public function handle()
    {
        // 檔案紀錄在 storage/logs/laravel.log
        $log_file_path = storage_path('laravel.log');

        //執行排程檢查
        $register = $this->telegram->botRegister('@sparkTestBot');;
        foreach ($register as $re) {
            //寫入log
            $log_info = '@register: '. (string) $re;
            File::append($log_file_path, $log_info);
        }
    }
}