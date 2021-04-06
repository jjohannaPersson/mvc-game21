<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use jopn20\Dice\Dice;
use jopn20\Dice\DiceHand;
use jopn20\Dice\GraphicalDice;
use jopn20\Dice\Game21;
use jopn20\Dice\Player;

use function Mos\Functions\url;

$header = $header ?? null;


?><h1><?= $header ?></h1>

<p>
    Din poäng: <?= $scores["human"] ?>
    <p class="dice-utf8">
        <?php foreach ($class as $value) : ?>
            <i class="<?= $value ?>"></i>
        <?php endforeach; ?>
    </p>
    <?php if ($scores["human"] === 21) :
        ?> <h3>Grattis!</h3>
    <?php endif ?>
</p>
<p>
    Datorns poäng: <?= $scores["computer"]?>
</p>

<?php if (!$roundIsOver) : ?>
    <form action="" method="POST">
        <input name="roll" id="roll" type="submit" value="Kasta"></input>
    </form>

    <form action="" method="POST">
        <input name="stay" id="stay" type="submit" value="Stanna"></input>
    </form>
<?php else : ?>
        <p><h3>Vinnaren är: <?= $winner ?></h3></p>
        <form action="" method="POST">
            <input name="play-again" id="play-again" type="submit" value="Spela igen"></input>
        </form>
<?php endif ?>

    <p>
        Dina vunna rundor: <?= $wonRounds["human"] ?>
    </p>
    <p>
        Datorns vunna rundor: <?= $wonRounds["computer"]?>
    </p>

<form action="" method="POST">
    <input name="new-game" id="new-game" type="submit" value="Nollställ poängen och starta en ny omgång"></input>
</form>
