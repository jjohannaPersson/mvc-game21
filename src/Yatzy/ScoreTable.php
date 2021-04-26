<?php

declare(strict_types=1);

namespace jopn20\Yatzy;

/**
 * Class ScoreTable.
 */
class ScoreTable
{
    private int $roundsLeft = 6;
    private array $table;

    public function __construct(array $currentTable = null)
    {
        if (is_null($currentTable)) {
            $this->table = array (
                "1" => null,
                "2" => null,
                "3" => null,
                "4" => null,
                "5" => null,
                "6" => null,
                "Summa" => 0,
                "Bonus" => 0,
                "rundorKvar" => 6
            );
        } else {
            $this->table = $currentTable;
        }
    }

    public function scores(string $face, int $value): array
    {
        if ($this->table[$face] == null) {
            $this->table[$face] = $value;
        }

        $this->table["Summa"] = $this->table["Summa"] + $value;

        $this->roundsLeft --;
        $this->table["rundorKvar"] = $this->roundsLeft;

        if ($this->roundsLeft == 0) {
            if ($this->table["Summa"] >= 63) {
                $this->table["Bonus"] = 50;
                $this->table["Summa"] = $this->table["Summa"] + $this->table["Bonus"];
            }
        }
        return $this->table;
    }

    public function getTable()
    {
        return $this->table;
    }
}
