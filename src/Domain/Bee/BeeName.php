<?php

namespace App\Domain\Bee;


class BeeName
{
    const FIRSTNAMES = [
        'Big',
        'The',
        'Massive',
        'Bizzy',
        'Honey',
        'Dumbledore',
        'Bumbles',
        'Buzz',
        'Beeatrice',
        'Steve',
        'Doug',
    ];

    const LASTNAMES = [
        'Pain',
        'Stinger',
        'Terminator',
        'Honey Potter',
        'Picnic Spoiler',
        'Jamhunter',
        'Sting',
        'Beelzebub'
    ];

    /**
     * Generate a bee name from available firstname and lastnames for bees.
     *
     * @return string
     */
    static function create():string
    {
        $firstname = self::FIRSTNAMES[array_rand(self::FIRSTNAMES)];
        $lastname = self::LASTNAMES[array_rand(self::LASTNAMES)];
        return $firstname . ' ' . $lastname;
    }
}