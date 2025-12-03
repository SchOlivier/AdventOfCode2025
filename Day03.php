<?php

$filename = 'inputDay03';
// $filename = 'inputDay03.example';

$file = fopen($filename, 'r');

$sum1 = $sum2 = 0;

while ($data = trim(fgets($file))) {
    $sum1 += getNumber($data, 2);
    $sum2 += getNumber($data, 12);
}
echo "part 1 answer: " . $sum1 . "\n";
echo "part 2 answer: " . $sum2 . "\n";
fclose($file);

function getNumber(string $data, int $nbDigits): int
{
    $string = $data;
    $number = 0;

    while ($nbDigits > 0) {
        $pos = findDigit($string, $nbDigits - 1);
        if ($pos === false) echo "wtf\n";
        $number += $string[$pos] * 10 ** ($nbDigits - 1);
        $string = substr($string, $pos + 1);
        $nbDigits--;
    }

    return $number;
}

function findDigit(string $string, int $remainingDigits): int | false
{
    $len = strlen($string);
    for ($i = 9; $i >= 0; $i--) {
        $pos = strpos($string, $i);
        if ($pos !== false && $len - $pos > $remainingDigits) {
            return $pos;
        }
    }
    return false;
}
