<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\TelegramRepository;
use App\Models\telegram\Bot;
use App\Models\telegram\Message;
use App\Models\telegram\Setting;
use App\Models\upgiSystem\User;
use Mockery\Mock;

class TelegramReponsitoryTest extends TestCase
{
    use DatabaseTransactions;

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
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->target = $this->app->make(TelegramRepository::class);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->target = null;
        $this->mock = null;
        parent::tearDown();
    }   

    public function testBasicExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test TelegramRepository@getBotData
     */
    public function testGetBotData()
    {
        /** arrange */
        $user = Bot::insert(['name' => 'test', 'token' => 'testToken', 'updateID' => '0']);
        $target = App::make(TelegramRepository::class);
        $name = 'test';
        $expected = 'test';

        /** act */
        $actual = $target->getBotData($name)->first()->name;

        /** assert */
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test TelegramRepository@getSettingValue
     */
    public function testGetSettingValue() 
    {
        /** arrange */
        $code = 'test';
        $value = 'testValue';
        $user = Setting::insert(['settingCode' => $code, 'value' => $value]);
        $target = App::make(TelegramRepository::class);
        $expected = $value;

        /** act */
        $actual = $target->getSettingValue($code);

        /** assert */
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test TelegramRepository@updateUserTelegramID
     */
    public function testUpdateUserTelegramID()
    {
        /** arrange */
        //$user = User::where('erpID', '<>', null)->first();
        User::insert([
            'ID' => 'testID',
            'mobileSystemAccount' => 'erpID',
            'erpID' => 'erpID',
        ]);
        $user = User::where('ID', 'testID');
        $userID = $user->first()->ID;
        $erpID = $user->first()->mobileSystemAccount;
        $telegramID = 'test1234';
        $target = App::make(TelegramRepository::class);
        $expected = $telegramID;

        /** act */
        $actual = $target->updateUserTelegramID($erpID, $telegramID);
        
        /** assert */
        $this->assertTrue($actual);
        $user = User::where('ID', $userID);
        $this->assertEquals($expected, $user->first()->telegramID);
        $user->delete();
    }

    /**
     * @test TelegramRepository@checkUser
     */
    public function testCheckUser()
    {
        /** arrange */
        User::insert([
            'ID' => 'testID2',
            'mobileSystemAccount' => 'erpID2',
            'erpID' => 'erpID2',
        ]);
        $user = User::where('ID', 'testID2');
        $userID = $user->first()->mobileSystemAccount;
        $target = App::make(TelegramRepository::class);
        $expected = true;

        /** act */
        $actual = $target->checkUser($userID);
        $user->delete();
        $actualFalse = $target->checkUser($userID);
        
        /** assert */
        $this->assertTrue($actual);
        $this->assertTrue(!$actualFalse);
    }

    /**
     * @test TelegramRepository@updateBotUpdateID
     */
    public function testUpdateBotUpdateID()
    {
        /** arrange */
        $this->target = $this->initMock(Bot::class);
        $this->mock->shouldReceive('update')
            ->once()
            ->withAnyArgs()
            ->andReturn(true);
        $expected = true;

        /** act */
        $actual = $target->updateBotUpdateID();
        
        /** assert */
        $this->assertTrue($actual);
        $this->assertTrue(!$actualFalse);
    }
}
