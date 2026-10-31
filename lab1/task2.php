<?php
$n = $_GET['n'] ?? '';
$m = $_GET['m'] ?? '';

$showResult = false;
$error = '';
$isSubmitted = isset($_GET['n']) || isset($_GET['m']);

if ($isSubmitted) {
	if ($n === '' || $m === '') {
		$error = 'Заполните оба поля';
	} elseif (!ctype_digit($n) || !ctype_digit($m)) {
		$error = 'Введите целые числа';
	} else {
		$nInt = (int)$n;
		$mInt = (int)$m;
		if ($nInt <= 0 || $mInt <= 0) {
			$error = 'Числа должны быть больше нуля';
		} else {
			$showResult = true;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Задача 2</title>
</head>
<body>
	<h1>Числа без нуля</h1>
	<form method="GET">
		<p>n: <input type="text" name="n" value="<?= htmlspecialchars($n) ?>"></p>
		<p>m: <input type="text" name="m" value="<?= htmlspecialchars($m) ?>"></p>
		<button type="submit">Найти</button>
	</form>

	<?php if ($error !== '') { ?>
		<p style="color: red;"><?= $error ?></p>
	<?php } ?>

	<?php if ($showResult) { ?>
		<?php
		$min = 1;
		for ($i = 1; $i < $nInt; $i++) { $min *= 10; }
		$limit = min($mInt, (int)str_repeat('9', $nInt));
		$found = [];
		for ($num = $min; $num <= $limit; $num++) {
			$str = (string)$num;
			if (strlen($str) !== $nInt || strpos($str, '0') !== false) continue;
			$good = true;
			for ($k = 0; $k < strlen($str); $k++) {
				if ($num % (int)$str[$k] !== 0) { $good = false; break; }
			}
			if ($good) $found[] = $num;
		}
		?>
		<?php if (count($found) === 0) { ?>
			<p>Подходящих чисел нет.</p>
		<?php } else { ?>
			<p>Найдено: <?= count($found) ?></p>
			<p><?= implode(', ', $found) ?></p>
		<?php } ?>
	<?php } ?>
	<p><a href="index.php">Назад</a></p>
</body>
</html>
