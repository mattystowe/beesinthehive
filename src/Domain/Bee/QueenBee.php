<?php

namespace App\Domain\Bee;

class QueenBee extends Bee
{
    protected $startingHealth = 100;
    protected $hitsDamage = 8;
    protected $type = 'Queen';

    /**
     * QueenBee constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

}