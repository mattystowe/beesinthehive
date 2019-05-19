<?php

namespace Tests;


use App\Domain\Bee\DroneBee;
use App\Domain\Bee\QueenBee;
use App\Domain\Bee\WorkerBee;

class BeeFactoryTest extends BaseTest
{
    protected function setup()
    {
        parent::setUp();

    }

    public function test_it_should_generate_array_of_queen_bees()
    {
        $bees = $this->beeFactory->generate('Queen', 5);
        $this->assertEquals(5,count($bees));
    }

    public function test_it_should_generate_array_of_worker_bees()
    {
        $bees = $this->beeFactory->generate('Worker', 5);
        $this->assertEquals(5,count($bees));
    }

    public function test_it_should_generate_array_of_drone_bees()
    {
        $bees = $this->beeFactory->generate('Drone', 5);
        $this->assertEquals(5,count($bees));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Wrong type of bee requested.
     */
    public function test_should_throw_error_for_incorrect_bee_type()
    {
        $this->beeFactory->generate('IncorrectType', 5);
    }

    public function test_createQueen_should_return_instance_of_queen()
    {
        $bee = $this->beeFactory->createQueen();
        $this->assertInstanceOf(QueenBee::class, $bee);
    }

    public function test_createWorker_should_return_instance_of_worker()
    {
        $bee = $this->beeFactory->createWorker();
        $this->assertInstanceOf(WorkerBee::class, $bee);
    }

    public function test_createWorker_should_return_instance_of_drone()
    {
        $bee = $this->beeFactory->createDrone();
        $this->assertInstanceOf(DroneBee::class, $bee);
    }




}