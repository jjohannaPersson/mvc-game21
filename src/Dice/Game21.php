<?php

declare(strict_types=1);

namespace jopn20\Dice;

use jopn20\Dice\Player;

/**
 * Class Game21.
 */
class Game21
{
    private $player;
    private $computerPlayer;
    private $roundEnded = false;

    public function __construct(int $dices = 1)
    {
        $this->player = new Player($dices);
        $this->computerPlayer = new Player($dices);
    }

    public function graphicDice()
    {
        return $this->player->getGraph();
    }

    public function rollPlayer()
    {
        $this->player->roll();
        return $this->player->getScore();
    }

    public function getScores()
    {
        return [
            "human" => $this->player->getScore(),
            "computer" => $this->computerPlayer->getScore()
        ];
    }

    public function getWonRounds()
    {
        return [
            "human" => $this->player->getWonRounds(),
            "computer" => $this->computerPlayer->getWonRounds()
        ];
    }

    public function setScorePlayer(int $testScore)
    {
        $this->player->setScore($testScore);
    }

    public function setScoreComputer(int $testScore)
    {
        $this->computerPlayer->setScore($testScore);
    }

    public function computer()
    {
        $this->computerPlayer->computer($this->player->getScore());
    }

    public function quitRound()
    {
        $scores = $this->getScores();
        if ($scores["human"] > $scores["computer"] && $scores["human"] < 22) {
            $this->player->incrementWonRounds();
        } elseif ($scores["human"] < 22 && $scores["computer"] > 21) {
            $this->player->incrementWonRounds();
        } else {
            $this->computerPlayer->incrementWonRounds();
        }
        $this->roundEnded = true;
    }

    public function getWinner(): string
    {
        $scores = $this->getScores();
        if ($scores["human"] > $scores["computer"] && $scores["human"] < 22) {
            return "Du";
        } elseif ($scores["human"] < 22 && $scores["computer"] > 21) {
            return "Du";
        }

        return "Datorn";
    }

    public function resetScores()
    {
        $this->player->resetScore();
        $this->computerPlayer->resetScore();
        $this->roundEnded = false;
    }

    public function roundIsOver()
    {
        return $this->roundEnded;
    }
}
