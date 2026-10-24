<?php
$n = $_GET['n'] ?? '';
$m = $_GET['m'] ?? '';

$showResult = false;
$error = '';

if ($n !== '' && $m !== '') {
    if (ctype_digit($n) && ctype_digit($m)) {
        $nInt = (int)$n;
        $mInt = (int)$m;

        if ($nInt > 0 && $mInt > 0) {
            $showResult = true;
        } else {
            $error = 'Числа должны быть больше нуля';
        }
    } else {
        $error = 'Нужно ввести целые положительные числа';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задача 2</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Числа без нуля, которые делятся на свои цифры</h1>

    <form method="GET">
        <p>Количество разрядов n: <input type="text" name="n" value="<?= $_GET['n'] ?? '' ?>"></p>
        <p>Максимальное число m: <input type="text" name="m" value="<?= $_GET['m'] ?? '' ?>"></p>
        <button type="submit">Найти</button>
    </form>

    <?php if ($error !== '') { ?>
        <p style="color: red;"><?= $error ?></p>
    <?php } ?>

    <?php if ($showResult) { ?>
        <?php
        $min = 1;
        for ($i = 1; $i < $nInt; $i++) {
            $min = $min * 10;
        }

        $limit = $mInt;
        if ($limit > (int)(str_repeat('9', $nInt))) {
            $limit = (int)(str_repeat('9', $nInt));
        }

        $found = [];

        for ($number = $min; $number <= $limit; $number++) {
            $str = (string)$number;

            if (strlen($str) !== $nInt) {
                continue;
            }

            if (strpos($str, '0') !== false) {
                continue;
            }

            $good = true;
            for ($k = 0; $k < strlen($str); $k++) {
                $digit = (int)$str[$k];
                if ($number % $digit !== 0) {
                    $good = false;
                    break;
                }
            }

            if ($good) {
                $found[] = $number;
            }
        }
        ?>

        <?php if (count($found) === 0) { ?>
            <p>Подходящих чисел нет.</p>
        <?php } else { ?>
            <p>Найдено чисел: <?= count($found) ?></p>
            <p><?= implode(', ', $found) ?></p>
        <?php } ?>
    <?php } ?>

    <p><a href="index.php">← Назад</a></p>
</body>
</html>