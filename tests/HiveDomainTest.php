<?php

namespace Tests;

use App\Domain\Bee\QueenBee;
use App\Domain\Hive\Hive;

class HiveDomainTest extends BaseTest
{

    protected function setup()
    {
        parent::setUp();
    }

    /**
     * @expectedException  \Exception
     * @expectedExceptionMessage You cannot add more than 1 queen to the hive
     */
    public function test_should_only_accept_one_queen_in_a_hive()
    {
        $hive = new Hive();
        $hive->addBees($this->beeFactory->generate('Queen',2));
    }

    public function test_should_allow_bees_to_be_added()
    {
        $hive = new Hive();
        $this->assertEquals(0, count($hive->getBees()));
        $hive->addBees($this->beeFactory->generate('Worker',5));
        $this->assertEquals(5, count($hive->getBees()));
    }

    public function test_if_queen_dies_then_all_bees_should_die()
    {
        //create an almost dead queen
        $queen = new QueenBee();
        $queen->setHealth(2);

        //mock the GetRandomLivingBee method in Hive to return almost dead queen
        $hive = $this->createPartialMock(Hive::class,['GetRandomLivingBee']);
        $hive->method('GetRandomLivingBee')->willReturn($queen);

        //add some other bees to the hive
        $hive->addBees($this->beeFactory->generate('Worker',10));

        //attack the queen so she dies.
        $hive->attack();

        //check that all bees are dead
        $this->assertEquals(false, $hive->isHiveAlive());
        $this->assertEquals(0, count($hive->getBees(false)));

    }

    public function test_should_know_if_it_has_a_queen()
    {
        $hive = new Hive();
        $this->assertEquals(false, $hive->hasAQueen());
        $hive->addBees($this->beeFactory->generate('Queen',1));
        $this->assertEquals(true, $hive->hasAQueen());
    }

    public function test_getBees_should_return_array_of_all_bees()
    {
        $hive = new Hive();
        $hive->addBees($this->beeFactory->generate('Worker',5));
        $this->assertEquals(5,count($hive->getBees()));
    }

    public function test_getBees_should_return_array_of_all_living_bees()
    {
        $hive = new Hive();
        $hive->addBees($this->beeFactory->generate('Worker',5));
        //kill a bee
        $bee = $hive->getRandomLivingBee()->kill();
        //should only return array of living bees
        $this->assertEquals(4,count($hive->getBees(false)));
    }

    public function test_killAllBees_should_kill_all_bees()
    {
        $hive = new Hive();
        $hive->addBees($this->beeFactory->generate('Worker',5));
        //kill a bee
        $hive->killAllBees();
        //should only return array of living bees
        $this->assertEquals(0,count($hive->getBees(false)));
    }
}
