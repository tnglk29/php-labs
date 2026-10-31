<?php
$n = $_GET['n'] ?? '';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$show = false;
$error = '';

if (isset($_GET['n']) || isset($_GET['min']) || isset($_GET['max'])) {
	if ($n === '' || $min === '' || $max === '') {
		$error = 'Заполните все поля';
	} elseif (!ctype_digit($n) || !is_numeric($min) || !is_numeric($max)) {
		$error = 'Введите корректные числа';
	} else {
		$nInt = (int)$n;
		$minF = (float)$min;
		$maxF = (float)$max;
		if ($nInt <= 0) {
			$error = 'n должно быть больше 0';
		} elseif ($minF > $maxF) {
			$error = 'Нижняя граница не может быть больше верхней';
		} else {
			$show = true;
		}
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
	<?php require '../menu.php'; ?>

	<div class="content">
		<h1>Массивы (Вариант 6)</h1>
		<form method="GET">
			<p>n: <input type="text" name="n" value="<?= htmlspecialchars($n) ?>"></p>
			<p>Мин: <input type="text" name="min" value="<?= htmlspecialchars($min) ?>"></p>
			<p>Макс: <input type="text" name="max" value="<?= htmlspecialchars($max) ?>"></p>
			<button type="submit">ОК</button>
		</form>

		<?php if ($error !== '') { ?>
			<p style="color: red;"><?= $error ?></p>
		<?php } ?>

		<?php if ($show) { ?>
			<?php
			$arr = [];
			for ($i = 0; $i < $nInt; $i++) {
				$randInt = rand($minF * 100, $maxF * 100);
				$arr[] = $randInt / 100;
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
				if ($arr[$i] < $minElem) { $minElem = $arr[$i]; $minIndex = $i; }
			}
			?>
			<p>Минимум: <?= $minElem ?>, Номер: <?= $minIndex + 1 ?></p>
			<hr>

			<h3>Пункт 2. Сумма между положительными</h3>
			<?php
			$firstPos = -1;
			$lastPos = -1;
			for ($i = 0; $i < $nInt; $i++) {
				if ($arr[$i] > 0) {
					if ($firstPos === -1) $firstPos = $i;
					$lastPos = $i;
				}
			}
			?>
			<?php if ($firstPos === -1 || $firstPos === $lastPos) { ?>
				<p>Нет двух положительных элементов.</p>
			<?php } else { 
				$sum = 0;
				for ($i = $firstPos + 1; $i < $lastPos; $i++) { $sum += $arr[$i]; }
			?>
				<p>Сумма: <?= $sum ?></p>
			<?php } ?>
			<hr>

			<h3>Пункт 3. Сначала нули, затем остальные</h3>
			<?php
			$zeros = [];
			$others = [];
			for ($i = 0; $i < $nInt; $i++) {
				if ($arr[$i] == 0) $zeros[] = $arr[$i];
				else $others[] = $arr[$i];
			}
			$newArr = array_merge($zeros, $others);
			?>
			<p>[<?= implode(', ', $newArr) ?>]</p>
		<?php } ?>
	</div>
</body>
</html>
