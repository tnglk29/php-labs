<?php
$n = $_GET['n'] ?? '';
$minVal = $_GET['min'] ?? '';
$maxVal = $_GET['max'] ?? '';

$showResult = false;
$error = '';

if ($n !== '' && $minVal !== '' && $maxVal !== '') {
    if (ctype_digit($n) && is_numeric($minVal) && is_numeric($maxVal)) {
        $nInt = (int)$n;
        $minFloat = (float)$minVal;
        $maxFloat = (float)$maxVal;

        if ($nInt > 0 && $minFloat < $maxFloat) {
            $showResult = true;
        } else {
            $error = 'n должно быть больше 0, а нижняя граница меньше верхней';
        }
    } else {
        $error = 'Введите корректные числа (n - целое)';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Массивы</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .content { margin-left: 240px; padding: 10px; }
    </style>
</head>
<body>
    <?php require 'menu.php'; ?>

    <div class="content">
        <h1>Задание с массивом (Вариант 6)</h1>

        <form method="GET">
            <p>Размерность n: <input type="text" name="n" value="<?= $_GET['n'] ?? '' ?>"></p>
            <p>Нижняя граница: <input type="text" name="min" value="<?= $_GET['min'] ?? '' ?>"></p>
            <p>Верхняя граница: <input type="text" name="max" value="<?= $_GET['max'] ?? '' ?>"></p>
            <button type="submit">Сгенерировать</button>
        </form>

        <?php if ($error !== '') { ?>
            <p style="color: red;"><?= $error ?></p>
        <?php } ?>

        <?php if ($showResult) { ?>
            <?php
            // генерируем исходный массив
            $arr = [];
            for ($i = 0; $i < $nInt; $i++) {
                $arr[] = rand($minFloat * 10, $maxFloat * 10) / 10;
            }
            ?>

            <h3>Исходный массив:</h3>
            <p>[<?= implode(', ', $arr) ?>]</p>

            <hr>

            <h3>Пункт 1. Минимальный элемент и его номер</h3>
            <?php
            $minElem = $arr[0];
            $minIndex = 0;
            for ($i = 1; $i < $nInt; $i++) {
                if ($arr[$i] < $minElem) {
                    $minElem = $arr[$i];
                    $minIndex = $i;
                }
            }
            ?>
            <p>Минимальный элемент: <?= $minElem ?></p>
            <p>Его номер: <?= $minIndex + 1 ?></p>

            <hr>

            <h3>Пункт 2. Сумма между первым и последним положительными</h3>
            <?php
            $firstPos = -1;
            $lastPos = -1;
            for ($i = 0; $i < $nInt; $i++) {
                if ($arr[$i] > 0) {
                    if ($firstPos === -1) {
                        $firstPos = $i;
                    }
                    $lastPos = $i;
                }
            }

            if ($firstPos === -1 || $firstPos === $lastPos) {
                echo "<p>Нет двух положительных элементов.</p>";
            } else {
                $sumBetween = 0;
                for ($i = $firstPos + 1; $i < $lastPos; $i++) {
                    $sumBetween = $sumBetween + $arr[$i];
                }
                echo "<p>Сумма: " . $sumBetween . "</p>";
            }
            ?>

            <hr>

            <h3>Пункт 3. Сначала нулевые, затем остальные</h3>
            <?php
            $zeros = [];
            $others = [];
            for ($i = 0; $i < $nInt; $i++) {
                if ($arr[$i] == 0) {
                    $zeros[] = $arr[$i];
                } else {
                    $others[] = $arr[$i];
                }
            }
            $newArr = array_merge($zeros, $others);
            ?>
            <p>[<?= implode(', ', $newArr) ?>]</p>

        <?php } ?>
    </div>
</body>
</html>