<?php

namespace App\Domain\Bee;

class DroneBee extends Bee
{
    protected $startingHealth = 50;
    protected $hitsDamage = 12;
    protected $type = 'Drone';

    /**
     * DroneBee constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

}