<?php
require 'functions.php';

// данные из форм
$text1 = $_GET['text1'] ?? '';
$text2 = $_GET['text2'] ?? '';
$char2 = $_GET['char2'] ?? '';
$text3 = $_GET['text3'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Строки</title>
</head>
<body>
    <h1>Строки (Вариант 2)</h1>

    <h2>Задание 1. Исправление текста</h2>
    <form method="GET">
        <input type="text" name="text1" value="<?= $text1 ?>" style="width: 300px;">
        <button type="submit">Исправить</button>
    </form>
    <?php if ($text1 !== '') { ?>
        <p>Исходный: <?= htmlspecialchars($text1) ?></p>
        <p>Исправленный: <?= htmlspecialchars(fixText($text1)) ?></p>
        <?php $stats = countWordsAndSentences(fixText($text1)); ?>
        <p>Слов: <?= $stats['words'] ?>, Предложений: <?= $stats['sentences'] ?></p>
    <?php } ?>

    <hr>

    <h2>Задание 2. Сортировка после символа</h2>
    <form method="GET">
        <p>Текст: <input type="text" name="text2" value="<?= $text2 ?>"></p>
        <p>Символ: <input type="text" name="char2" value="<?= $char2 ?>"></p>
        <button type="submit">Сортировать</button>
    </form>
    <?php if ($text2 !== '' && $char2 !== '') { ?>
        <p>Исходный: <?= htmlspecialchars($text2) ?></p>
        <p>Результат: <?= htmlspecialchars(sortAfterChar($text2, $char2)) ?></p>
    <?php } ?>

    <hr>

    <h2>Задание 3. Только заглавные слова</h2>
    <form method="GET">
        <input type="text" name="text3" value="<?= $text3 ?>" style="width: 300px;">
        <button type="submit">Найти</button>
    </form>
    <?php if ($text3 !== '') { ?>
        <p>Исходный: <?= htmlspecialchars($text3) ?></p>
        <p>Результат: <?= htmlspecialchars(findCapitalWords($text3)) ?></p>
    <?php } ?>

    <p><a href="index.php">Назад</a></p>
</body>
</html>