<?php

namespace Tests;

use App\Domain\Bee\DroneBee;
use App\Domain\Bee\QueenBee;
use App\Domain\Bee\WorkerBee;

class BeeDomainTest extends BaseTest
{
    private $beeDataStructure = [
        'Type' => null,
        'Name' => null,
        'Status' => null,
        'Health' => null,
        'XP' => null,
    ];

    protected function setup()
    {
        parent::setUp();
    }

    public function test_a_queen_should_have_starting_health_of_100_and_hitsdamage_of_8()
    {
        $queen = new QueenBee();
        $this->assertEquals(100, $queen->getHealth());
        $this->assertEquals(8, $queen->getHitsDamage());
    }

    public function test_a_worker_should_have_starting_health_of_75_and_hitsdamage_of_10()
    {
        $worker = new WorkerBee();
        $this->assertEquals(75, $worker->getHealth());
        $this->assertEquals(10, $worker->getHitsDamage());
    }

    public function test_a_drone_should_have_starting_health_of_50_and_hitsdamage_of_12()
    {
        $drone = new DroneBee();
        $this->assertEquals(50, $drone->getHealth());
        $this->assertEquals(12, $drone->getHitsDamage());
    }

    public function test_damage_should_reduce_health()
    {
        $bee = new QueenBee();
        $bee->inflictDamage();
        $this->assertEquals(92, $bee->getHealth());
    }

    public function test_should_be_dead_if_health_reaches_zero()
    {
        $bee = new QueenBee();
        $bee->setHealth(0);
        $this->assertEquals(true, $bee->isDead());
    }

    public function test_it_should_be_killed_using_kill_override()
    {
        $bee = new QueenBee();
        $bee->kill();
        $this->assertEquals(true, $bee->isDead());
    }

    public function test_it_should_export_data_for_leaderboard()
    {
        $bee = new QueenBee();
        foreach ($this->beeDataStructure as $key=>$value) {
            $this->assertArrayHasKey($key, $bee->exportsData());
        }
    }

}
