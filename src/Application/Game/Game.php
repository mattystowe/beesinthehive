<?php

namespace App\Application\Game;


use App\Application\BeeJoke\Service\BeeJokeService;
use App\Domain\Hive\Hive;
use GuzzleHttp\Client;
use League\CLImate\CLImate;

class Game
{
    /**
     * @var Hive
     */
    private $hive;

    /**
     * @var CLImate
     */
    private $cli;

    /**
     * @var string Status
     */
    private $status;

    /**
     * @var int Number of turns taken in the game
     */
    private $turns;

    const STATUS_RUNNING = 'running';
    const STATUS_GAMEOVER = 'gameover';
    const STATUS_WAITING_FOR_PLAYER = 'waitingforplayer';
    const STATUS_EXITED = 'exited';

    /**
     * Game constructor.
     * @param Hive $hive
     */
    public function __construct(Hive $hive, $cli)
    {
        $this->hive = $hive;
        $this->cli = $cli;
        $this->status = self::STATUS_WAITING_FOR_PLAYER;
        $this->turns = 0;
    }

    /**
     * Run the game cycle
     *
     */
    public function run():void
    {
        $this->cli->clear();
        while (!$this->isGameOver() && !$this->isGameExited()) {

            //Display option menu
            $input = $this->renderMenu();

            switch ($input) {
                case 'exit':
                    $this->exitGame();
                    break;
                case 'hit':
                    $this->takeTurn();
                    break;
            }
        }
    }

    /**
     * Render the main menu and return input selection result from user.
     *
     * @return string
     */
    private function renderMenu():string
    {
        return $this->cli->input(
            'What do you want to do?',
            ['hit', 'exit']
        );
    }


    /**
     * Let the player take the turn.
     *
     */
    public function takeTurn():void
    {
        //Attack the hive
        $this->hive->attack();

        //show leader board
        $this->cli->clear();
        $this->renderResults();

        //Output the last attack result
        $this->cli->br();
        $this->cli->lightCyan($this->hive->getLastLog());
        $this->cli->br();

        //increment number of turns
        $this->turns++;

        //Are there any living bees in the hive?
        if (!$this->hive->isHiveAlive()) {
            $this->gameOver();
        }

    }

    /**
     * Render the current results.
     *
     */
    private function renderResults():void
    {
        $this->cli->backgroundGreen('***** Bee Leader board *****');
        $this->cli->br();
        $bees = $this->hive->prepareLeaderboard();
        $this->cli->table($bees);
        $this->cli->br();
        $this->cli->green('You have taken ' . $this->turns . ' turns');
    }


    /**
     * Set the game as Game Over.
     */
    private function gameOver():void
    {
        $this->status = self::STATUS_GAMEOVER;
        $this->cli->br();
        $this->cli->red('******** GAME OVER! *********');
        $this->cli->br();
        $this->cli->red('All the bees are dead :-( ');
        $this->renderResults();
    }

    /**
     * Is the game over?
     *
     * @return bool
     */
    public function isGameOver():bool
    {
        return $this->status == self::STATUS_GAMEOVER;
    }

    /**
     * Exit the game
     */
    private function exitGame():void
    {
        $this->status = self::STATUS_EXITED;
        $this->cli->clear();
        $this->cli->br();
        $this->cli->green('Thanks for playing! - You should really play something better next time!');
        $this->cli->br();
    }


    /**
     * Has the game been exited?
     *
     * @return bool
     */
    public function isGameExited():bool
    {
        return $this->status == self::STATUS_EXITED;
    }

    /**
     * @return string
     */
    public function getStatus():string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getTurns():int
    {
        return $this->turns;
    }
}