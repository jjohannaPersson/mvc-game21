<?php

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use jopn20\Yatzy\ScoreTable;

/**
 * Test cases for the controller Yatzy.
 */
class ControllerYatzyTest extends TestCase
{
    /**
    * Try to create the controller class.
    */
    public function testCreateTheControllerClass()
    {
        $controller = new Yatzy();
        $this->assertInstanceOf("\Mos\Controller\Yatzy", $controller);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseYatzy()
    {
        $controller = new Yatzy();
        $_SESSION['rollsLeft'] = 2;

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->yatzy();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseYatzyPost()
    {
        $_SESSION['table'] = array (
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
        $_SESSION['rollsLeft'] = 2;
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->yatzypost();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseRollAgain()
    {
        $_SESSION = $this->setUpSessions();
        $controller = new Yatzy();
        $_POST['selectedDice'] = [1, 2, 3];

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->rollagain();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseRollAgainNoSelectedDice()
    {
        $_SESSION = $this->setUpSessions();
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->rollagain();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseScore()
    {
        $_SESSION = $this->setUpSessions();
        $controller = new Yatzy();
        $_POST["selectedScore"] = [1 => 3];

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->score();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseRecordScore()
    {
        $_SESSION = $this->setUpSessions();
        $_POST["selectedScore"] = "1";
        $controller = new Yatzy();
        $_SESSION['possibleScores'] = [1 => 3];

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->recordScore();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseGameOver()
    {
        session_start();
        $_SESSION = $this->setUpSessions();
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->gameOver();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    * Check the controller action.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseRollSelected()
    {
        $_SESSION = $this->setUpSessions();

        $exp = "rolledDices";
        $this->assertArrayHasKey($exp, $_SESSION);
        $this->assertIsArray($_SESSION["rolledDices"]);
    }

    private function setUpSessions()
    {
        $table = array (
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
        $_SESSION = [
            "rolledDices" => [1, 2, 3, 4, 5],
            "table" => $table,
            "rollsLeft" => 2
        ];
        return $_SESSION;
    }
}
