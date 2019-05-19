<?php

namespace App\Application\Bee\Factory;


use App\Domain\Bee\DroneBee;
use App\Domain\Bee\QueenBee;
use App\Domain\Bee\WorkerBee;

class BeeFactory
{

    /**
     * Generate an array of bee objects
     *
     * @param string $type
     * @param int $quantity
     * @return mixed|array
     */
    public function generate(string $type, $quantity = 1):array
    {
        $bees = [];
        for ($i=1; $i <= $quantity; ++$i) {
            switch ($type) {
                case 'Queen':
                    $bees[] = $this->createQueen();
                    break;
                case 'Worker':
                    $bees[] = $this->createWorker();
                    break;
                case 'Drone':
                    $bees[] = $this->createDrone();
                    break;
                default:
                    throw new \Exception('Wrong type of bee requested.', 500);
            }
        }
        return $bees;
    }

    /**
     * Create a QueenBee
     *
     * @return QueenBee
     */
    public function createQueen():QueenBee
    {
        return new QueenBee();
    }

    /**
     * Create a WorkerBee
     *
     * @return WorkerBee
     */
    public function createWorker():WorkerBee
    {
        return new WorkerBee();
    }

    /**
     * Create a DroneBee
     *
     * @return DroneBee
     */
    public function createDrone():DroneBee
    {
        return new DroneBee();
    }
}