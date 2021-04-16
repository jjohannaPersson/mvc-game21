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
 * Class DiceHand.
 */
class DiceHand
{
    private $dice = array();
    private $sum;
    private $grap = 0;

    public function __construct(int $dices)
    {
        $this->grap = $dices;
        for ($i = 0; $i < $dices; $i++) {
            $this->dice[$i] = new GraphicalDice();
        }
    }

    public function graphicDices()
    {
        $res = [];
        $class = [];
        for ($i = 0; $i < $this->grap; $i++) {
            $res[] = $this->dice[$i]->getLastRoll();
            $class[] = $this->dice[$i]->graphic();
        }
        return $class;
    }



    public function roll(): void
    {
        $len = count($this->dice) - 1;

        $this->sum = 0;
        for ($i = 0; $i <= $len; $i++) {
            $this->sum += $this->dice[$i]->roll();
        }
    }

    public function getLastRoll(): string
    {
        $len = count($this->dice) - 1;
        $res = "";
        for ($i = 0; $i <= $len; $i++) {
            $res .= $this->dice[$i]->getLastRoll() . ", ";
        }
        return $res . " = " . $this->sum;
    }

    public function getLastRollArray(int $dices): array
    {
        $res = array();
        for ($i = 0; $i < $dices; $i++) {
            $res[$i] = $this->dice[$i]->getLastRoll();
        }
        return $res;
    }


    public function getSum()
    {
        return $this->sum;
    }
}
