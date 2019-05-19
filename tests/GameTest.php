<?php

namespace Tests;


use App\Application\Cli\Service\CliService;
use App\Application\Game\Game;
use App\Domain\Hive\Hive;

class GameTest extends BaseTest
{

    public $mockHive;
    public $mockCli;

    protected function setup()
    {
        parent::setUp();
        $this->mockCli = $this->createMock(CliService::class);
        $this->mockHive = $this->createMock(Hive::class);
    }

    public function test_should_initialise_with_correct_starting_states()
    {
        $game = new Game($this->mockHive, $this->mockCli);
        $this->assertEquals(Game::STATUS_WAITING_FOR_PLAYER, $game->getStatus());
        $this->assertEquals(0, $game->getTurns());
    }

    public function test_should_be_game_over_if_all_bees_are_dead()
    {
        $this->mockHive->method('isHiveAlive')->willReturn(false);
        $game = new Game($this->mockHive, $this->mockCli);
        $game->takeTurn();
        $this->assertEquals(Game::STATUS_GAMEOVER, $game->getStatus());

    }

    public function test_should_increment_turn_numbers_for_each_hit()
    {
        $this->mockHive->method('isHiveAlive')->willReturn(false);
        $game = new Game($this->mockHive, $this->mockCli);
        $this->assertEquals(0, $game->getTurns());
        $game->takeTurn();
        $this->assertEquals(1, $game->getTurns());
    }
}