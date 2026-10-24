<?php
$rows = $_GET['rows'] ?? '';
$cols = $_GET['cols'] ?? '';

$showTable = false;
$error = '';

if ($rows !== '' && $cols !== '') {
    if (ctype_digit($rows) && ctype_digit($cols)) {
        $rowsInt = (int)$rows;
        $colsInt = (int)$cols;

        if ($rowsInt > 0 && $colsInt > 0) {
            $showTable = true;
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
    <title>Таблица умножения</title>
    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            border: 1px solid black;
            width: 50px;
            height: 50px;
            text-align: center;
        }

        .head {
            background: yellow;
            font-weight: bold;
        }

        .even {
            background: green;
        }

        .odd {
            background: blue;
        }

        .diag {
            background: pink;
        }
    </style>
</head>
<body>
    <h1>Введите размерность таблицы</h1>

    <form method="GET">
        <input type="text" name="rows" value="<?= $_GET['rows'] ?? '' ?>">
        <input type="text" name="cols" value="<?= $_GET['cols'] ?? '' ?>">
        <button type="submit">Отправить</button>
    </form>

    <?php if ($error !== '') { ?>
        <p style="color: red;"><?= $error ?></p>
    <?php } ?>

    <?php if ($showTable) { ?>
        <table>
            <tr>
                <td class="head"></td>
                <?php for ($j = 1; $j <= $colsInt; $j++) { ?>
                    <td class="head"><?= $j ?></td>
                <?php } ?>
            </tr>

            <?php for ($i = 1; $i <= $rowsInt; $i++) { ?>
                <tr>
                    <td class="head"><?= $i ?></td>

                    <?php for ($j = 1; $j <= $colsInt; $j++) {
                        $value = $i * $j;

                        $class = '';
                        if ($rowsInt === $colsInt && $i === $j) {
                            $class = 'diag';
                        } elseif ($value % 2 === 0) {
                            $class = 'even';
                        } else {
                            $class = 'odd';
                        }
                    ?>
                        <td class="<?= $class ?>"><?= $value ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <p><a href="index.php">← Назад</a></p>
</body>
</html>