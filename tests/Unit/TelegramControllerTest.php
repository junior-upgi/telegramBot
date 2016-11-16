<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\TelegramController;
use App\Repositories\TelegramRepository;
use App\Service\TelegramService;
use Mockery\Mock;


class TelegramControllerTest extends TestCase
{
    /**
     * 建立$target property， 負責放待測物件
     * 
     * @var UserController
     */
    protected $target;

    /**
     * 建立$mock property，負責放mock物件
     * 
     * @var Mock
     */
    protected $mock;

    /**
     * Setup the test environment.
     *
     * 每個TestCase執行時，都會自動執行setUp()，因此可以在此建立mock物件與待測物件。
     * 一定要先建立mock物件，才能建立待測物件，因為UserController需要依賴UserRepository注入，
     * 所以需要先使用$this->app->instance()先建立好mock物件，再執行$this->app->make()，否則PHPUnit會報錯。
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->initMock(TelegramRepository::class);
        $this->mock = $this->initMock(TelegramService::class);
        $this->target = $this->app->make(TelegramController::class);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * 每個TestCase執行完，都會自動執行tearDown()，因此可以在此將$target與$mock設定為null，避免下次unit test受到干擾。
     * 
     * 在Laravel 5.1，Mockery::close()會在Illuminate\Foundation\Testing\TestCase的tearDown()被執行，
     * 因此我們不必再自己加Mockery::close()，不過在Laravel 4.2，我們必須自己在tearDown()加Mockery::close()，否則mock不會正常執行。
     *
     * @return void
     */
    public function tearDown()
    {
        $this->target = null;
        $this->mock = null;
        parent::tearDown();
    }

    /**
     * Test TelegramController@getUpdates
     *
     * @group TelegramController
     * @group TelegramController0
     */
    public function testGetUpdates()
    {
        /**
         * 寫controlller的unit test依然會依照3A原則 : arrange、act與assert。
         * arrange : 準備測試資料 $fake、mock物件 $mock、待測物件 $target，與建立測試期望值 $expected。
         * act : 執行待測物件的method，建立實際結果值 $actual。
         * assert : 使用PHPUnit的assertXXX()測試$expected與$actual是否如預期。
         */

        
        // arrange
        $expected = ['ok' => true, 'result' => ''];
        $this->mock->shouldReceive('botRegister')
            ->once()
            ->with('test')
            //->withAnyArgs()
            ->andReturn($expected);

        // act
        $result = $this->target->getUpdates('test');

        // assert
        $this->assertEquals($expected, $result);
    }

}
