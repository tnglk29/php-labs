<?php
$snils = $_GET['snils'] ?? '';

$showResult = false;
$error = '';

if ($snils !== '') {
    $clean = str_replace('-', '', $snils);
    $clean = str_replace(' ', '', $clean);

    if (ctype_digit($clean) && strlen($clean) === 11) {
        $showResult = true;
    } else {
        $error = 'Введите номер в формате ХХХ-ХХХ-ХХХ УУ';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Проверка СНИЛС</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Проверка контрольного числа СНИЛС</h1>

    <form method="GET">
        <p>Номер СНИЛС: <input type="text" name="snils" value="<?= $_GET['snils'] ?? '' ?>" placeholder="112-233-445 95"></p>
        <button type="submit">Проверить</button>
    </form>

    <?php if ($error !== '') { ?>
        <p style="color: red;"><?= $error ?></p>
    <?php } ?>

    <?php if ($showResult) { ?>
        <?php
        $number = substr($clean, 0, 9);
        $control = (int)substr($clean, 9, 2);

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $digit = (int)$number[$i];
            $position = 9 - $i;
            $sum = $sum + $digit * $position;
        }

        if ($sum < 100) {
            $expected = $sum;
        } elseif ($sum === 100 || $sum === 101) {
            $expected = 0;
        } else {
            $remainder = $sum % 101;
            if ($remainder < 100) {
                $expected = $remainder;
            } else {
                $expected = 0;
            }
        }

        $isValid = ($expected === $control);

        $formatted = substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6, 3) . ' ' . substr($clean, 9, 2);
        ?>

        <p>Номер: <?= $formatted ?></p>
        <p>Сумма: <?= $sum ?></p>
        <p>Ожидаемое контрольное число: <?= $expected ?></p>
        <p>Указанное контрольное число: <?= $control ?></p>

        <?php if ($isValid) { ?>
            <p style="color: green;">Номер корректный</p>
        <?php } else { ?>
            <p style="color: red;">Номер некорректный</p>
        <?php } ?>

        <?php if ($number <= '001001998') { ?>
            <p style="color: orange;">Внимание: для номеров до 001-001-998 проверка не проводится</p>
        <?php } ?>
    <?php } ?>

    <p><a href="index.php">← Назад</a></p>
</body>
</html>