<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\telegram\Bot;


class ExampleTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function MySQL測試料庫連線()
    {
        /** arrange */
        $expected = 2;

        /** act */
        $actual = Bot::all();

        /** assert */
        $this->assertCount($expected, $actual);
    }
}
