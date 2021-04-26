<?php

declare(strict_types=1);

namespace jopn20\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the class Game21.
 */
class DiceGame21Test extends TestCase
{
    /**
    * Try to create the controller class.
    */
    public function testCreateTheControllerClass()
    {
        $controller = new Game21();
        $this->assertInstanceOf("\jopn20\Dice\Game21", $controller);
    }

    /**
    * Try to create the controller class.
    */
    public function testgetWinner()
    {
        $controller = new Game21();
        $controller->setScorePlayer(21);
        $controller->setScoreComputer(20);

        $exp = "Du";
        $res = $controller->getWinner();
        $this->assertEquals($res, $exp);
        $res = $controller->quitRound();
    }

    /**
    * Try to create the controller class.
    */
    public function testgetWinner2()
    {
        $controller = new Game21();
        $controller->setScorePlayer(20);
        $controller->setScoreComputer(23);

        $exp = "Du";
        $res = $controller->getWinner();
        $this->assertEquals($res, $exp);
        $res = $controller->quitRound();
    }

    /**
    * Try to create the controller class.
    */
    public function testComputer()
    {
        $controller = new Player(1);
        $res = $controller->computer(22);

        $this->assertNull($res);
    }
}
