<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * 初始化mock物件
     *
     * @param string $class
     * @return Mockery
     */
    public function initMock($class)
    {
        $mock = Mockery::mock($class); /** Mockery是PHP負責做mock的package，Laravel預設已經整合在內。*/
        $this->app->instance($class, $mock); /** 告訴Laravel的service container，當type hint為該class時，使用指定的物件。*/
        /**
         * 與$this->app->bind()的差異是 :
         * bind()用來將指定的interface與class做連結。(不需指定class與class連結，Laravel會自動處理)
         * instance()則是用來將指定的interface或class與物件做連結。
         */

        return $mock;
    }
}
