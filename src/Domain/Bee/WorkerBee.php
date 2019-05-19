<?php

namespace App\Domain\Bee;

class WorkerBee extends Bee
{
    protected $startingHealth = 75;
    protected $hitsDamage = 10;
    protected $type = 'Worker';

    /**
     * WorkerBee constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

}