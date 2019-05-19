<?php

namespace App\Domain\Bee;

class Bee
{
    protected $startingHealth;

    /**
     * Health of the bee.
     * @var int
     */
    protected $health;

    /**
     * The amount of damage that a bee takes on when hit.
     * @var int
     */
    protected $hitsDamage;

    /**
     * The type of bee.
     * @var string
     */
    protected $type;

    /**
     * The bee name.
     * @var string
     */
    protected $realName;

    /**
     * Bee constructor.
     */
    public function __construct()
    {
        $this->health = $this->startingHealth;
        $this->realName = BeeName::create();
    }

    /**
     * Get the starting health for this bee
     *
     * @return int
     */
    public function getStartingHealth():int
    {
        return $this->startingHealth;
    }

    /**
     * Get the current health of the bee.
     * @return int
     */
    public function getHealth():int
    {
        return $this->health;
    }

    /**
     * Set health
     *
     * @param int $health
     * @return Bee
     */
    public function setHealth(int $health):Bee
    {
        $this->health = $health;
        return $this;
    }

    /**
     * Get the type of bee.
     * @return string
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     * Get the hits damage amount for this bee.
     *
     * @return int
     */
    public function getHitsDamage():int
    {
        return $this->hitsDamage;
    }

    /**
     * Inflict damage on the bee.
     */
    public function inflictDamage():void {
        $this->health = $this->health - $this->hitsDamage;
        if ($this->health < 0) { $this->health = 0; }
    }

    /**
     * Get the real name of the bee.
     * @return string
     */
    public function getRealName():string
    {
        return $this->realName;
    }

    /**
     * Return life status of bee
     *
     * @return bool
     */
    public function isDead():bool
    {
        return $this->getHealth() == 0;
    }

    /**
     * Kill the bee
     *
     */
    public function kill():void
    {
        $this->setHealth(0);
    }

    /**
     * Public export json serialised record for the bee
     *
     * @return mixed
     */
    public function exportsData()
    {
        $xp = ceil(($this->getHealth() / $this->getStartingHealth()) * 10);
        return [
          'Type' => $this->getType(),
          'Name' => $this->getRealName(),
          'Status' => $this->isDead() ? 'Dead' : 'Alive',
          'Health' => $this->getHealth(),
          'XP' => str_pad('->',  $xp, "*"),
        ];
    }
}