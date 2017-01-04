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
class Test30Console extends Command
{
    /** @var string 命令名稱 */
    protected $signature = 'test30';
    /** @var string 命令描述 */
    protected $description = '每30分鐘檢查DB';
    /** @var TelegramService */
    private $telegram;

    /**
     * 建構式
     *
     * @param TelegramSzervice $check
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
        $log_file_path = storage_path('logs/laravel.log');

        //執行系統監控
        $log = $this->telegram->test();
        $log_info = '#每30分：' . \Carbon\Carbon::now() .  $log['success'] . ': ' . $log['msg'] . "\r\n";
        File::append($log_file_path, $log_info);
    }
}