<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use jopn20\Dice\Dice;
use jopn20\Dice\DiceHand;
use jopn20\Dice\GraphicalDice;

use function Mos\Functions\url;

$header = $header ?? null;
$message = $message ?? null;


?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<form action="" method="POST">
    <input type="radio" name="dices" id="dices" value="1">
        <label for="dices">1</label><br>
    <input type="radio" name="dices" id="dices" value="2">
        <label for="dices">2</label><br>
    <input name="start-game" id="start-game" type="submit" value="Börja spela!">
</form>
