<?php

declare(strict_types=1);

namespace jopn20\Yatzy;

use jopn20\Dice\DiceHand;

/**
 * Class YatzyGame.
 */
class YatzyGame
{
    private DiceHand $diceHand;
    private array $rolledDices;
    private int $dices = 5;
    private ScoreTable $scoreTable;

    public function __construct(ScoreTable $table)
    {
        $this->scoreTable = $table;
        $this->diceHand = new DiceHand($this->dices);
    }

    public function startGame(): void
    {
        $this->rollDices();
    }

    public function rollDices(): void
    {
        $this->diceHand->roll();
        $this->rolledDices = $this->diceHand->getLastRollArray($this->dices);
    }

    public function getRolledDices(): array
    {
        return $this->rolledDices;
    }

    public function rollroll(int $newDiceqty): array
    {
        $newDiceValues = array();
        $rollDiceHand = new DiceHand($newDiceqty);
        $rollDiceHand->roll();
        $newDiceValues = $rollDiceHand->getLastRollArray($newDiceqty);
        return $newDiceValues;
    }

    public function getScores(): array
    {
        return $this->scoreTable->getTable();
    }

    public function scorableCombos(array $rolledDices): array
    {
        $values = $rolledDices;

        $scorecombos = array(
            "1" => 0,
            "2" => 0,
            "3" => 0,
            "4" => 0,
            "5" => 0,
            "6" => 0,
        );

        for ($i = 1; $i <= 6; $i++) {
            foreach ($values as $possibleDuplicate) {
                if ($possibleDuplicate == $i) {
                    $scorecombos["$i"] ++;
                }
            }
        }
        return $scorecombos;
    }

    public function comboTotal(array $combos): array
    {
        $totalPossibleScores = array(
            "1" => 0,
            "2" => 0,
            "3" => 0,
            "4" => 0,
            "5" => 0,
            "6" => 0,
        );

        foreach ($combos as $key => $value) {
            $totalPossibleScores[$key] = intval($key) * $value;
        }

        return $totalPossibleScores;
    }

    public function setScore(string $face, int $value)
    {
        $this->scoreTable->scores($face, $value);
    }
}
