<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use jopn20\Dice\Dice;
use jopn20\Dice\DiceHand;
use jopn20\Dice\Game21;

use function Mos\Functions\{
    redirectTo,
    renderView,
    url
};

/**
 * Class Game.
 */
class Game
{
    use ControllerTrait;

    public function dice(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Tärningar",
            "message" => "Testar!",
        ];

        $die = new Dice(6);
        $die->roll();

        $diceHand = new DiceHand(2);
        $diceHand->roll();

        $data["dieLastRoll"] = $die->getLastRoll();
        $data["diceHandRoll"] = $diceHand->getLastRoll();

        $body = renderView("layout/dice.php", $data);
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function game21(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        if (!array_key_exists("game", $_SESSION)) {
                $_SESSION["game"] = new Game21();
        }

        $data = [
            "header" => "Game 21",
            "message" => "Välj om du vill spela med en eller två tärningar:",
        ];

        $body = renderView("layout/game21.php", $data);
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function game21post(): ResponseInterface
    {
        $game = $_SESSION["game"];

        if (array_key_exists("dices", $_POST)) {
            $dices = intval($_POST["dices"]);
            $_SESSION["game"] = new Game21($dices);
        }

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/play21"));
    }

    public function play21(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
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
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function play21post()
    {
        $game = $_SESSION["game"];

        if (array_key_exists("roll", $_POST)) {
            $game->rollPlayer();
            $tot = $game->getScores()["human"];
            if ($tot === 21) {
                $game->quitRound();
            } elseif ($tot > 21) {
                $game->quitRound();
            }
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", url("/play21"));
        } elseif (array_key_exists("stay", $_POST)) {
            $game->computer();
            $game->quitRound();
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", url("/play21"));
        } elseif (array_key_exists("play-again", $_POST)) {
            $game->resetScores();
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", url("/play21"));
        } elseif (array_key_exists("new-game", $_POST)) {
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", url("/game21"));
        };
    }
}
