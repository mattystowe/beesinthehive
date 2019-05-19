<?php

namespace App\Domain\Hive;


use App\Domain\Bee\Bee;

class Hive
{
    /**
     * Collection of bees in the hive
     * @var array
     */
    protected $bees = [];

    /**
     * Hive log
     * @var array
     */
    protected $log = [];

    /**
     * Hive constructor.
     */
    public function __construct()
    {
        $this->writeToLog('Hive setup!');
    }

    /**
     * Add bees to the hive
     *
     * @param array $bees
     * @return Hive
     * @throws \Exception
     */
    public function addBees(array $bees):Hive
    {
        foreach ($bees as $bee) {
            if ($bee->getType() === 'Queen' && $this->hasAQueen()) {
                throw new \Exception('You cannot add more than 1 queen to the hive');
            }
            $this->bees[] = $bee;
        }
        return $this;
    }

    /**
     * Does the hive already have a queen
     * @return bool
     */
    public function hasAQueen():bool
    {
        foreach ($this->getBees() as $bee) {
            if ($bee->getType = 'Queen') {
                return true;
            }
        }
        return false;
    }

    /**
     * Get array of all living bees in the hive
     *
     * @param bool $all [true default. false = only living bees]
     * @return array
     */
    public function getBees(bool $all = true):array
    {
        if ($all) {
            return $this->bees;
        }

        //get only living bees
        $livingBees = [];
        foreach ($this->getBees() as $bee) {
            if (!$bee->isDead()) {
                $livingBees[] = $bee;
            }
        }
        return $livingBees;
    }

    /**
     * Attack the hive
     *
     */
    public function attack()
    {
        //select a random bee (can only select living bees to attack!)
        $bee = $this->getRandomLivingBee();

        //inflict damage on the bee
        $bee->inflictDamage();

        //Prep and send the damage report to the hive log
        $log = $bee->getType() . ' '
            . $bee->getRealName()
            . ' took a direct hit for '
            . $bee->getHitsDamage()
            . ' points! (' . $bee->getHealth() . ' remaining).';
        $this->writeToLog($log);

        //check if queen bee killed
        if ($bee->isDead() && $bee->getType() == 'Queen') {
            //
            //Queen is dead - terminate all bees
            $this->killAllBees();
            $this->writeToLog('The Queen is dead... Long live the Queen...!');
        }
    }

    /**
     * Kill all bees in the hive
     *
     */
    public function killAllBees():void
    {
        foreach ($this->getBees() as $bee) {
            $bee->kill();
        }
    }

    /**
     * Get a random bee in the hive
     *
     * @return Bee
     */
    public function getRandomBee():Bee
    {
        return $this->getBees()[array_rand($this->getBees())];
    }

    /**
     * Get a random living bee in the hive
     *
     * @return Bee
     */
    public function getRandomLivingBee():Bee
    {
        return $this->getBees(false)[array_rand($this->getBees(false))];
    }

    /**
     * Get the last log string
     *
     * @return string
     */
    public function getLastLog():string
    {
        return array_pop($this->log);
    }

    /**
     * Write to the hive log
     *
     * @param string $log
     */
    private function writeToLog(string $log):void
    {
        $this->log[] = $log;
    }

    /**
     * Is the hive alive - are there any bees still living?
     * @return bool
     */
    public function isHiveAlive():bool
    {
        foreach ($this->getBees() as $bee) {
            if (!$bee->isDead()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Prepare the leaderboard data
     *
     * @return array
     */
    public function prepareLeaderboard():array
    {
        //Get the bees in the hive
        $bees = $this->getBees();

        //sort them by their health
        usort($bees, function($a, $b) {
            return $b->getHealth() - $a->getHealth();
        });

        //build up table data object
        $data = [];
        foreach ($bees as $bee) {
            $data[] = $bee->exportsData();
        }
        return $data;
    }
}