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
 * Class GraphicalDice.
 */
class GraphicalDice extends Dice
{
    const FACES = 6;

    public function __construct()
    {
        parent::__construct(self::FACES);
    }

    public function graphic()
    {
        return "dice-sprite dice-" . $this->getLastRoll();
    }
}
