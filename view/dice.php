<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use jopn20\Dice\GraphicalDice;

$header = $header ?? null;
$message = $message ?? null;

$dice = new GraphicalDice();
$rolls = 6;
$res = [];
$class = [];
for ($i = 0; $i < $rolls; $i++) {
    $res[] = $dice->roll();
    $class[] = $dice->graphic();
}

?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<p>Dice!</p>

<p><?= $dieLastRoll ?></p>

<p>DiceHand!</p>

<p><?= $diceHandRoll ?></p>

<p>Graphic</p>
<p class="dice-utf8">
    <?php foreach ($class as $value) : ?>
        <i class="<?= $value ?>"></i>
    <?php endforeach; ?>
</p>
