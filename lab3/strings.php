<?php
require 'functions.php';

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
	<?php require '../menu.php'; ?>
	
	<div style="margin-left: 240px;">
		<h1>Строки (Вариант 2)</h1>

		<h2>Задание 1</h2>
		<form method="GET">
			<input type="text" name="text1" value="<?= htmlspecialchars($text1) ?>" style="width: 300px;">
			<button type="submit">Исправить</button>
		</form>
				<?php if ($text1 !== '') { ?>
			<?php if (mb_substr($text1, -1) !== '.') { ?>
				<p style="color:red;">Текст должен заканчиваться точкой!</p>
			<?php } else { ?>
				<p>Исходный: <?= htmlspecialchars($text1) ?></p>
				<p>Исправленный: <?= htmlspecialchars(fixText($text1)) ?></p>
				<?php $stats = countWordsAndSentences(fixText($text1)); ?>
				<p>Слов: <?= $stats['words'] ?>, Предложений: <?= $stats['sentences'] ?></p>
			<?php } ?>
		<?php } ?>

		<hr>

		<h2>Задание 2</h2>
		<form method="GET">
			<p>Текст: <input type="text" name="text2" value="<?= htmlspecialchars($text2) ?>"></p>
			<p>Символ: <input type="text" name="char2" value="<?= htmlspecialchars($char2) ?>"></p>
			<button type="submit">Сортировать</button>
		</form>
		<?php if ($text2 !== '' && $char2 !== '') { ?>
			<?php if (mb_substr($text2, -1) !== '.') { ?>
				<p style="color:red;">Текст должен заканчиваться точкой!</p>
			<?php } else {
				$res2 = sortAfterChar($text2, $char2);
			?>
				<p>Исходный: <?= htmlspecialchars($text2) ?></p>
				<?php if ($res2['pos'] === null) { ?>
					<p>Символ не найден.</p>
				<?php } else { ?>
					<p>Позиция символа: <?= $res2['pos'] ?></p>
					<p>Результат: <?= htmlspecialchars($res2['result']) ?></p>
				<?php } ?>
			<?php } ?>
		<?php } ?>

		<hr>

		<h2>Задание 3</h2>
		<form method="GET">
			<input type="text" name="text3" value="<?= htmlspecialchars($text3) ?>" style="width: 300px;">
			<button type="submit">Найти</button>
		</form>
		<?php if ($text3 !== '') { ?>
			<?php if (mb_substr($text3, -1) !== '.') { ?>
				<p style="color:red;">Текст должен заканчиваться точкой!</p>
			<?php } else { ?>
				<p>Исходный: <?= htmlspecialchars($text3) ?></p>
				<p>Результат: <?= htmlspecialchars(findCapitalWords($text3)) ?></p>
			<?php } ?>
		<?php } ?>
	</div>
</body>
</html>
