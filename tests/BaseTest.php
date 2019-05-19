<?php

namespace Tests;


use App\Application\Bee\Factory\BeeFactory;

class BaseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var BeeFactory
     */
    public $beeFactory;

    protected function setUp()
    {
        $this->beeFactory = new BeeFactory();
    }

    public function test_it_should_do_something()
    {
        $this->assertTrue(true);
    }

    /**
     *
     * TODO Add more tests here
     *
     *
     *
     *
     *
     *
     *
     */
}
