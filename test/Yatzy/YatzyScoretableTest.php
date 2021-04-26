<?php

declare(strict_types=1);

namespace jopn20\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the class Scortable.
 */

class YatzyScoretableTest extends TestCase
{
    /**
    * Try to create the controller class.
    */
    public function testCreateTheControllerClass()
    {
        $controller = new ScoreTable();
        $this->assertInstanceOf("\jopn20\Yatzy\ScoreTable", $controller);
    }

    /**
    * Test that the method retu an array with changed values.
    */
    public function testScores()
    {
        $controller = new ScoreTable();
        $score = 36;

        $res = array();
        for ($face = 1; $face < 7; $face++) {
            $res = $controller->scores((string)($face), $score);
        }

        $exp = 50;
        $this->assertEquals($exp, $res["Bonus"]);
    }
}
