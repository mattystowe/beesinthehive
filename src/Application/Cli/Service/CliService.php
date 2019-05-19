<?php

namespace App\Application\Cli\Service;


use League\CLImate\CLImate;

class CliService
{
    private $cli;

    public function __construct()
    {
        $this->cli = new CLImate();
    }

    /**
     * Clear the terminal
     */
    public function clear()
    {
        $this->cli->clear();
    }

    /**
     * Ask a question and return the input
     *
     * @param string $question
     * @param array $accepts
     * @return string
     */
    public function input(string $question, array $accepts):string
    {
        $input = $this->cli->input($question);
        $input->accept($accepts, true);
        return $input->prompt();
    }

    /**
     * Line break terminal
     */
    public function br():void
    {
        $this->cli->br();
    }

    /**
     * Output to terminal in light cyan colour
     *
     * @param string $text
     */
    public function lightCyan(string $text):void
    {
        $this->cli->lightCyan($text);
    }

    /**
     * Output to the terminal in green background
     *
     * @param string $text
     */
    public function backgroundGreen(string $text):void
    {
        $this->cli->backgroundGreen($text);
    }

    /**
     * Output a table to the command line
     *
     * @param array $array
     */
    public function table(array $array):void
    {
        $this->cli->table($array);
    }

    /**
     * Output to terminal in green text
     *
     * @param string $text
     */
    public function green(string $text):void
    {
        $this->cli->green($text);
    }

    /**
     * Output to the terminal in red text
     *
     * @param string $text
     */
    public function red(string $text):void
    {
        $this->cli->red($text);
    }




}