<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;

$header = $header ?? null;
$message = $message ?? null;

$diceNumber = 1;
$tableArray = $_SESSION['table'];
$tablekey = array_keys($table);

?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<?php if ($tableArray["rundorKvar"] > 0) { ?>
    <form method="POST" class="dices" action="<?= url("/yatzy/rollagain") ?>">

        <?php foreach ($_SESSION['rolledDices'] as $diceface) {?>
            <input type="checkbox" name="selectedDice[]" id="die<?= $diceNumber ?>" value=<?= $diceNumber ?> />
            <label name="selectedDice[]" for="die<?= $diceNumber ?>">
                <i class="dice-sprite dice-<?= $diceface ?>"></i>
            </label>
            <?php
            $diceNumber++;
        } ?>

        <div class="roll-again">
            <?php if ($_SESSION['rollsLeft'] > 0) {?>
                <input type="submit" class="roll-again" value="Kasta igen"></input>
            <?php } else { ?>
                <h3>Inga kast kvar</h3>
            <?php } ?>
        </div>
    </form>

    <form method="POST" action="<?= url("/yatzy/score") ?>">
            <input type="submit" class="stay" value="Stanna / Välj poäng"></input>
        </form>

    <div class="possible-scores">
        <form method="POST" action="<?= url("/yatzy/record-score") ?>">
            <?php if (isset($_SESSION['possibleScores'])) {
                foreach ($_SESSION['possibleScores'] as $key => $value) {?>
                        <input type="radio"  name="selectedScore" value="<?= $key ?>" id="<?= $key ?>"
                        <?php if (!empty($tableArray[$key]) || ($tableArray[$key] > -1)) { ?>
                                disabled
                        <?php } ?>
                        >
                        <label for="<?= $key ?>"
                            <?php if (!empty($tableArray[$key]) || ($tableArray[$key] > -1)) { ?>
                                style="text-decoration: line-through"
                            <?php } ?>
                        >
                        <?= $tablekey[$key - 1]?>: <?= $value ?>
                        </label><br>
                <?php } ?>
                <input type="submit" class="roll" value="Välj poäng"></input>
            <?php } ?>
        </form>
    </div>
<?php } ?>

    <div>
        <table class="game-table">
            <tr>
                <th>Yatzy</th>
                <th>Poäng</th>
            </tr>
            <tr>
                <td>Ettor:</td>
                <td><?= $tableArray["1"] ?></td>
            </tr>
            <tr>
                <td>Tvåor:</td>
                <td><?= $tableArray["2"] ?></td>
            </tr>
            <tr>
                <td>Treor:</td>
                <td><?= $tableArray["3"] ?></td>
            </tr>
            <tr>
                <td>Fyror:</td>
                <td><?= $tableArray["4"] ?></td>
            </tr>
            <tr>
                <td>Femmor:</td>
                <td><?= $tableArray["5"] ?></td>
            </tr>
            <tr>
                <td>Sexor:</td>
                <td><?= $tableArray["6"] ?></td>
            </tr>
            <tr>
                <td>Summa:</td>
                <td><?= $tableArray["Summa"] ?></td>
            </tr>
            <tr>
                <td>Bonus:</td>
                <td><?= $tableArray["Bonus"] ?></td>
            </tr>
        </table>
    </div>

    <form action="<?= url("/yatzy/game-over") ?>" method="POST">
        <input name="new-game" id="new-game" type="submit" value="Nollställ poängen och starta en ny omgång"></input>
    </form>
