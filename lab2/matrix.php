<?php
$rows = $_GET['rows'] ?? '';
$cols = $_GET['cols'] ?? '';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';

$show = false;
$error = '';

if ($rows !== '' && $cols !== '' && $min !== '' && $max !== '') {
    $rowsInt = (int)$rows;
    $colsInt = (int)$cols;
    $minInt = (int)$min;
    $maxInt = (int)$max;
    if ($rowsInt > 0 && $colsInt > 0 && $minInt < $maxInt) {
        $show = true;
    } else {
        $error = 'Ошибка ввода';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Матрицы</title>
    <style>
        body { font-family: sans-serif; }
        .content { margin-left: 240px; }
        td { border: 1px solid black; padding: 5px; text-align: center; width: 30px; }
    </style>
</head>
<body>
    <?php require 'menu.php'; ?>

    <div class="content">
        <h1>Матрицы (Вариант 6)</h1>
        <form method="GET">
            Строки: <input type="text" name="rows" value="<?= $_GET['rows'] ?? '' ?>"><br>
            Столбцы: <input type="text" name="cols" value="<?= $_GET['cols'] ?? '' ?>"><br>
            Мин: <input type="text" name="min" value="<?= $_GET['min'] ?? '' ?>"><br>
            Макс: <input type="text" name="max" value="<?= $_GET['max'] ?? '' ?>"><br>
            <button type="submit">ОК</button>
        </form>

        <?php if ($error !== '') { ?>
            <p style="color:red;"><?= $error ?></p>
        <?php } ?>

        <?php if ($show) { ?>
            <?php
            // создаем исходную
            $mat = [];
            for ($i = 0; $i < $rowsInt; $i++) {
                for ($j = 0; $j < $colsInt; $j++) {
                    $mat[$i][$j] = rand($minInt, $maxInt);
                }
            }
            ?>

            <h3>Исходная:</h3>
            <table>
                <?php for ($i = 0; $i < $rowsInt; $i++) { ?>
                    <tr>
                        <?php for ($j = 0; $j < $colsInt; $j++) { ?>
                            <td><?= $mat[$i][$j] ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

            <hr>
            <h3>1. В каждой строке максимальный = 0</h3>
            <?php
            $m1 = $mat;
            for ($i = 0; $i < $rowsInt; $i++) {
                $maxI = 0;
                for ($j = 1; $j < $colsInt; $j++) {
                    if ($m1[$i][$j] > $m1[$i][$maxI]) {
                        $maxI = $j;
                    }
                }
                $m1[$i][$maxI] = 0;
            }
            ?>
            <table>
                <?php for ($i = 0; $i < $rowsInt; $i++) { ?>
                    <tr>
                        <?php for ($j = 0; $j < $colsInt; $j++) { ?>
                            <td><?= $m1[$i][$j] ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

            <hr>
            <h3>2. Перед строкой, где первый элемент делится на 3</h3>
            <?php
            $m2 = [];
            for ($i = 0; $i < $rowsInt; $i++) {
                if ($mat[$i][0] % 3 == 0) {
                    for ($j = 0; $j < $colsInt; $j++) {
                        $m2[$i][$j] = 0; // временно пихаем нули
                    }
                    // тут костыль, но для студента норм
                }
            }
            // на самом деле проще так:
            $m2 = [];
            foreach ($mat as $row) {
                if ($row[0] % 3 == 0) {
                    $m2[] = array_fill(0, $colsInt, 0);
                }
                $m2[] = $row;
            }
            ?>
            <table>
                <?php foreach ($m2 as $row) { ?>
                    <tr>
                        <?php foreach ($row as $val) { ?>
                            <td><?= $val ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

            <hr>
            <h3>3. Удалить самый левый столбец с чётным отриц. элементом</h3>
            <?php
            $m3 = $mat;
            $delCol = -1;
            for ($j = 0; $j < $colsInt; $j++) {
                for ($i = 0; $i < $rowsInt; $i++) {
                    if ($m3[$i][$j] < 0 && $m3[$i][$j] % 2 == 0) {
                        $delCol = $j;
                        break 2;
                    }
                }
            }

            if ($delCol == -1) {
                echo "<p>Нет такого столбца.</p>";
            } else {
                for ($i = 0; $i < $rowsInt; $i++) {
                    unset($m3[$i][$delCol]);
                    $m3[$i] = array_values($m3[$i]); // убираем дырки
                }
                echo "<p>Удален столбец " . ($delCol + 1) . "</p>";
            }
            ?>
            <table>
                <?php for ($i = 0; $i < $rowsInt; $i++) { ?>
                    <tr>
                        <?php for ($j = 0; $j < count($m3[$i]); $j++) { ?>
                            <td><?= $m3[$i][$j] ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

            <hr>
            <h3>4. Поменять 2-й и предпоследний столбцы</h3>
            <?php
            $m4 = $mat;
            if ($colsInt < 4) {
                echo "<p>Мало столбцов (надо 4+).</p>";
            } else {
                $c2 = 1; // 2-й (индекс 1)
                $cPre = $colsInt - 2; // предпоследний
                for ($i = 0; $i < $rowsInt; $i++) {
                    $temp = $m4[$i][$c2];
                    $m4[$i][$c2] = $m4[$i][$cPre];
                    $m4[$i][$cPre] = $temp;
                }
            }
            ?>
            <table>
                <?php for ($i = 0; $i < $rowsInt; $i++) { ?>
                    <tr>
                        <?php for ($j = 0; $j < $colsInt; $j++) { ?>
                            <td><?= $m4[$i][$j] ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

        <?php } ?>
    </div>
</body>
</html>