<?php
// Задание 1. Исправление текста (Замена строчных на прописные после точки)
function fixText(string $text): string
{
    $text = str_replace('.', '. ', $text);
    $text = str_replace('.  ', '. ', $text); // убираем двойные пробелы, если были
    
    $len = mb_strlen($text);
    for ($i = 0; $i < $len; $i++) {
        $char = mb_substr($text, $i, 1);
        if ($char == '.') {
            $j = $i + 1;
            // пропускаем пробелы после точки
            while ($j < $len && mb_substr($text, $j, 1) == ' ') {
                $j++;
            }
            // делаем букву заглавной
            if ($j < $len) {
                $letter = mb_substr($text, $j, 1);
                $upperLetter = mb_strtoupper($letter);
                $text = mb_substr($text, 0, $j) . $upperLetter . mb_substr($text, $j + 1);
                $i = $j; // сдвигаем основной цикл
            }
        }
    }
    return $text;
}

// Счетчик слов и предложений
function countWordsAndSentences(string $text): array
{
    $words = explode(' ', trim($text));
    $wordCount = 0;
    foreach ($words as $w) {
        if ($w !== '' && $w !== '.') {
            $wordCount++;
        }
    }
    
    // считаем предложения по точкам
    $sentenceCount = substr_count($text, '.');
    if ($sentenceCount == 0 && trim($text) != '') {
        $sentenceCount = 1;
    }
    
    return ['words' => $wordCount, 'sentences' => $sentenceCount];
}

// Задание 2. Сортировка после символа
function sortAfterChar(string $text, string $char): string
{
    $pos = mb_strpos($text, $char);
    
    if ($pos === false) {
        return $text; // символ не найден
    }
    
    // часть до символа (включительно) и после
    $before = mb_substr($text, 0, $pos + 1);
    $after = mb_substr($text, $pos + 1);
    
    // сортируем часть после (используем обычную сортировку)
    $afterArr = mb_str_split($after);
    sort($afterArr);
    $afterSorted = implode('', $afterArr);
    
    return $before . $afterSorted;
}

// Задание 3. Найти слова из заглавных букв
function findCapitalWords(string $text): string
{
    // убираем точку в конце
    $text = str_replace('.', '', $text);
    
    // разбиваем по пробелам
    $words = explode(' ', $text);
    $result = [];
    
    foreach ($words as $word) {
        if ($word === '') {
            continue;
        }
        
        $isCapital = true;
        $len = mb_strlen($word);
        
        for ($i = 0; $i < $len; $i++) {
            $char = mb_substr($word, $i, 1);
            // если буква строчная — не подходит
            if ($char !== mb_strtoupper($char)) {
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
?>