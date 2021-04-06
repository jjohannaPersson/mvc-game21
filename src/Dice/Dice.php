<?php

declare(strict_types=1);

namespace jopn20\Dice;

// use function Mos\Functions\{
//     destroySession,
//     redirectTo,
//     renderView,
//     renderTwigView,
//     sendResponse,
//     url
// };

/**
 * Class Dice.
 */
class Dice
{
    private $roll = 0;
    private $faces = 0;

    public function __construct(int $faces = 6)
    {
        $this->faces = $faces;
    }

    public function getFaces()
    {
        return $this->faces;
    }

    public function roll(): int
    {
        $this->roll = rand(1, $this->getFaces());

        return $this->roll;
    }

    public function getLastRoll(): int
    {
        return $this->roll;
    }
}
