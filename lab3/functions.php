<?php

function fixText(string $text): string
{
	$len = mb_strlen($text);
	for ($i = 0; $i < $len; $i++) {
		$char = mb_substr($text, $i, 1);
		if ($char == '.') {
			$j = $i + 1;
			while ($j < $len && mb_substr($text, $j, 1) == ' ') {
				$j++;
			}
			if ($j < $len) {
				$letter = mb_substr($text, $j, 1);
				$text = mb_substr($text, 0, $j) . mb_strtoupper($letter) . mb_substr($text, $j + 1);
				$i = $j;
			}
		}
	}
	return $text;
}

function countWordsAndSentences(string $text): array
{
	$words = explode(' ', trim($text));
	$wordCount = 0;
	foreach ($words as $w) {
		if ($w !== '' && $w !== '.') {
			$wordCount++;
		}
	}
	
	$sentenceCount = substr_count($text, '.');
	if ($sentenceCount == 0 && trim($text) != '') {
		$sentenceCount = 1;
	}
	
	return ['words' => $wordCount, 'sentences' => $sentenceCount];
}


function sortAfterChar(string $text, string $char): array
{
	$pos = mb_strpos($text, $char);
	
	if ($pos === false) {
		return ['pos' => null, 'result' => $text];
	}
	
	$before = mb_substr($text, 0, $pos + 1);
	$after = mb_substr($text, $pos + 1);
	
	$afterArr = mb_str_split($after);
	sort($afterArr);
	
	return ['pos' => $pos + 1, 'result' => $before . implode('', $afterArr)];
}


function findCapitalWords(string $text): string
{
	
	if (mb_substr($text, -1) === '.') {
		$text = mb_substr($text, 0, -1);
	}
	
	$words = explode(' ', $text);
	$result = [];
	
	$russianLetters = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';
	
	foreach ($words as $word) {
		if ($word === '') continue;
		
		$isCapital = true;
		$len = mb_strlen($word);
		
		for ($i = 0; $i < $len; $i++) {
			$char = mb_substr($word, $i, 1);
			
			
			if (mb_strpos($russianLetters, $char) === false) {
				$isCapital = false;
				break;
			}
		}
		
		if ($isCapital) {
			$result[] = $word;
		}
	}
	
	if (count($result) == 0) {
		return "Нет подходящих слов";
	}
	
	return implode(' ', $result) . '.';
}
