<?php
/**
 * Bootstrap the game.
 *
 *
 */
require 'vendor/autoload.php';

//Initialise the CLI
$cli = new \App\Application\Cli\Service\CliService();

//Create the beehive.
$hive = new \App\Domain\Hive\Hive();

//Initiate the bee factory.
$beeFactory = new \App\Application\Bee\Factory\BeeFactory();

//Fill the hive with bees.
$hive
    ->addBees($beeFactory->generate('Queen', 1))
    ->addBees($beeFactory->generate('Worker', 5))
    ->addBees($beeFactory->generate('Drone', 8));

//Initialise the game.
$game = new \App\Application\Game\Game($hive, $cli);

//Boot the game.
$game->run();
