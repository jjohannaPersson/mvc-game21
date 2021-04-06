<?php

declare(strict_types=1);

namespace Mos\Router;

use jopn20\Dice\Game;
use jopn20\Dice\Game21;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Index page",
                "message" => "Hello, this is the index page, rendered as a layout.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/dice") {
            $callable = new Game();
            $callable->playGame();
            return;
        } else if ($method === "GET" && $path === "/game21") {
            $callable1 = new Game();
            $callable1->game21();
            return;
        } else if ($method === "POST" && $path === "/game21") {
            $game = $_SESSION["game"];

            if (array_key_exists("dices", $_POST)) {
                $dices = intval($_POST["dices"]);
                $_SESSION["game"] = new Game21($dices);
            }

            redirectTo(url("/play21"));
            return;
        } else if ($method === "GET" && $path === "/play21") {
            $callable1 = new Game();
            $callable1->play21();
            return;
        } else if ($method === "POST" && $path === "/play21") {
            $game = $_SESSION["game"];

            if (array_key_exists("roll", $_POST)) {
                $game->rollPlayer();
                $tot = $game->getScores()["human"];
                if ($tot === 21) {
                    $game->quitRound();
                } elseif ($tot > 21) {
                    $game->quitRound();
                }
                redirectTo(url("/play21"));
            } elseif (array_key_exists("stay", $_POST)) {
                $game->computer();
                $game->quitRound();
                redirectTo(url("/play21"));
            } elseif (array_key_exists("play-again", $_POST)) {
                $game->resetScores();
                redirectTo(url("/play21"));
            } elseif (array_key_exists("new-game", $_POST)) {
                redirectTo(url("/game21"));
            }
            return;
        }

        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
