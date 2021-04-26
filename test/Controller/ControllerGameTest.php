<?php

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use jopn20\Dice\Game21;
use jopn20\Dice\Player;

/**
 * Test cases for the controller Game.
 */
class ControllerGameTest extends TestCase
{
    /**
    * Try to create the controller class.
    */
    public function testCreateTheControllerClass()
    {
        $controller = new Game();
        $this->assertInstanceOf("\Mos\Controller\Game", $controller);
    }

    /**
    * Check that the controller returns a response with
    * dice().
    */
    public function testControllerReturnsResponseDice()
    {
        $controller = new Game();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->dice();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseGame21()
    {
        session_start();
        $controller = new Game();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->game21();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponseGame21post()
    {
        session_start();
        $controller = new Game();
        $_POST["dices"] = 2;
        $dices = intval($_POST["dices"]);
        $_SESSION["game"] = new Game21($dices);

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->game21post();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponsePlay21()
    {
        session_start();
        $controller = new Game();
        $_SESSION["game"] = new Game21(2);

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->play21();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponsePlay21post()
    {
        session_start();
        $controller = new Game();
        $_SESSION["game"] = new Game21(2);
        $_SESSION["game"]->setScorePlayer(21);

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->play21post();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponsePlay21postRoll()
    {
        session_start();
        $controller = new Game();
        $_SESSION["game"] = new Game21(2);
        $_POST["roll"] = null;
        $_SESSION["game"]->getScores()["human"] = 21;

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->play21post();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponsePlay21postStay()
    {
        session_start();
        $controller = new Game();
        $_SESSION["game"] = new Game21(2);
        $_POST["stay"] = null;

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->play21post();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponsePlay21postAgain()
    {
        session_start();
        $controller = new Game();
        $_SESSION["game"] = new Game21(2);
        $_POST["play-again"] = null;

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->play21post();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerReturnsResponsePlay21postNewGame()
    {
        session_start();
        $controller = new Game();
        $_SESSION["game"] = new Game21(2);
        $_POST["new-game"] = null;

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->play21post();
        $this->assertInstanceOf($exp, $res);
    }
}
