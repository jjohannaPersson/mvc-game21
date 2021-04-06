<?php

declare(strict_types=1);

namespace jopn20\Dice;

use jopn20\Dice\Dice;
use jopn20\Dice\DiceHand;
use jopn20\Dice\Game21;

use function Mos\Functions\{
    redirectTo,
    renderView,
    sendResponse,
    url
};

/**
 * Class Game.
 */
class Game
{
    public function playGame(): void
    {
        $data = [
            "header" => "Game 21",
            "message" => "Välj om du vill spela med en eller två tärningar!",
        ];

        $die = new Dice(6);
        $die->roll();

        $diceHand = new DiceHand(2);
        $diceHand->roll();

        $data["dieLastRoll"] = $die->getLastRoll();
        $data["diceHandRoll"] = $diceHand->getLastRoll();

        $body = renderView("layout/dice.php", $data);
        sendResponse($body);
    }

    public function game21(): void
    {
        if (!array_key_exists("game", $_SESSION)) {
                $_SESSION["game"] = new Game21();
        }

        $data = [
            "header" => "Game 21",
            "message" => "Välj om du vill spela med en eller två tärningar:",
        ];

        $body = renderView("layout/game21.php", $data);
        sendResponse($body);
    }

    public function play21(): void
    {
        $game = $_SESSION["game"];

        $data = [
            "header" => "Game 21",
            "scores" => $game->getScores(),
            "class" => $game->graphicDice(),
            "wonRounds" => $game->getWonRounds(),
            "winner" => $game->getWinner(),
            "roundIsOver" => $game->roundIsOver()
        ];

        $body = renderView("layout/play21.php", $data);
        sendResponse($body);
    }
}
