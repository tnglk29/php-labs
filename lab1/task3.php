<?php
$snils = $_GET['snils'] ?? '';
$showResult = false;
$error = '';

if ($snils !== '') {
	$clean = str_replace(['-', ' '], '', $snils);
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
	<title>СНИЛС</title>
</head>
<body>
	<h1>Проверка СНИЛС</h1>
	<form method="GET">
		<input type="text" name="snils" value="<?= htmlspecialchars($snils) ?>">
		<button type="submit">Проверить</button>
	</form>

	<?php if ($error !== '') { ?>
		<p style="color: red;"><?= $error ?></p>
	<?php } ?>

	<?php if ($showResult) { ?>
		<?php
		$number = substr($clean, 0, 9);
		$control = (int)substr($clean, 9, 2);

		if ((int)$number <= 1001998) {
			echo "<p style='color: orange;'>Для номеров до 001-001-998 проверка не проводится.</p>";
		} else {
			$sum = 0;
			for ($i = 0; $i < 9; $i++) {
				$sum += (int)$number[$i] * (9 - $i);
			}
			if ($sum < 100) { $expected = $sum; }
			elseif ($sum === 100 || $sum === 101) { $expected = 0; }
			else {
				$rem = $sum % 101;
				$expected = ($rem < 100) ? $rem : 0;
			}
			$isValid = ($expected === $control);
			$formatted = substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6, 3) . ' ' . substr($clean, 9, 2);
		?>
			<p>Номер: <?= $formatted ?></p>
			<?php if ($isValid) { ?>
				<p style="color: green;">Номер корректный</p>
			<?php } else { ?>
				<p style="color: red;">Номер некорректный</p>
			<?php } ?>
		<?php } ?>
	<?php } ?>
	<p><a href="index.php">Назад</a></p>
</body>
</html>
