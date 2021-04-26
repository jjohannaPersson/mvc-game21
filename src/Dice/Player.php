<?php

declare(strict_types=1);

namespace jopn20\Dice;

use jopn20\Dice\DiceHand;

/**
 * Class Player.
 */
class Player
{
    private $hand;
    private $score = 0;
    private $wonRounds = 0;

    public function __construct(int $dices)
    {
        $this->hand = new DiceHand($dices);
    }

    public function roll()
    {
        $this->hand->roll();
        $this->score += $this->hand->getSum();
    }

    public function getGraph()
    {
        return $this->hand->graphicDices();
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function computer(int $val)
    {
        if ($val > 21) {
            return;
        }
        while ($this->score <= $val && $this->score < 21) {
            $this->roll();
        }
    }

    public function resetScore()
    {
        $this->score = 0;
    }

    public function setScore(int $testScore)
    {
        $this->score = $testScore;
    }

    public function incrementWonRounds()
    {
        $this->wonRounds++;
    }

    public function getWonRounds()
    {
        return $this->wonRounds;
    }
}
