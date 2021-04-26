<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use jopn20\Yatzy\YatzyGame;
use jopn20\Yatzy\ScoreTable;

use function Mos\Functions\{
    destroySession,
    renderView,
    url
};

/**
 * Class Yatzy.
 */
class Yatzy
{
    private YatzyGame $yatzygame;
    private ScoreTable $scoreTable;
    private array $currentSession;

    public function yatzy(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $this->init();
        $_SESSION['rollsLeft'] = 2;
        $this->uploadTable();

        $data = [
            "header" => "Yatzy",
            "message" => "Det här är spelet yatzy!",
        ];

        $body = renderView("layout/yatzy.php", $data);
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function yatzypost(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $this->init();

        if (!array_key_exists("rolledDices", $this->currentSession)) {
            $this->yatzygame->rollDices();
            $rolledDices = $this->yatzygame->getRolledDices();
            $_SESSION['rolledDices'] = $rolledDices;
        }

        $data = [
            "header" => "Yatzy",
            "message" => "Klicka på de tärningar som du vill kasta igen:",
            "table" => array (
                "Ettor" => 1,
                "Tvåor" => "2",
                "Treor" => "3",
                "Fyror" => "4",
                "Femmor" => "5",
                "Sexor" => "6"
            )
        ];

        $body = renderView("layout/playyatzy.php", $data);
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function rollagain(): ResponseInterface
    {
        $this->init();

        if ($_SESSION["rollsLeft"] > 0) {
            $this->rollSelected();
            $_SESSION["rollsLeft"] = $_SESSION['rollsLeft'] - 1;
        }

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy/playyatzy"));
    }

    private function rollSelected()
    {
        $startRolls = $_SESSION["rolledDices"];

        if (!isset($_POST['selectedDice'])) {
            return;
        }

        $selectedDice = $_POST['selectedDice'];

        $newDiceQty = count($selectedDice);
        $newDiceValues = $this->yatzygame->rollroll($newDiceQty);
        $num = 0;

        foreach ($selectedDice as $selected) {
            $startRolls[$selected - 1] = $newDiceValues[$num];
            $num++;
        }

        $_SESSION['rolledDices'] = $startRolls;
    }

    public function score(): ResponseInterface
    {
        $this->init();

        $combos =  $this->yatzygame->scorableCombos($_SESSION['rolledDices']);
        $possibleScores = $this->yatzygame->comboTotal($combos);
        $_SESSION['possibleScores'] = $possibleScores;
        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy/playyatzy"));
    }

    public function recordScore(): ResponseInterface
    {
        $this->init();

        if (isset($_POST['selectedScore'])) {
            $key = $_POST['selectedScore'];
            $this->yatzygame->setScore($key, $_SESSION['possibleScores'][$key]);
            $_SESSION['table'] = $this->yatzygame->getScores();
        }
        unset($_SESSION['possibleScores']);
        unset($_SESSION['rolledDices']);
        $_SESSION['rollsLeft'] = 2;

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy/playyatzy"));
    }

    public function gameOver(): ResponseInterface
    {
        destroySession();
        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    private function init()
    {
        $this->currentSession = $_SESSION;
        if (array_key_exists('table', $this->currentSession)) {
            $table = $this->currentSession['table'];
            $this->scoreTable = new ScoreTable($table);
        } elseif (!array_key_exists('table', $this->currentSession)) {
            $this->scoreTable = new ScoreTable();
        }

        $this->yatzygame = new YatzyGame($this->scoreTable->getTable());
    }

    private function uploadTable()
    {
        $_SESSION['table'] = $this->scoreTable->getTable();
    }
}
