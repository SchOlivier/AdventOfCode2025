<?php

$filename = 'inputDay01';
// $filename = 'inputDay01.example';

$file = fopen($filename, 'r');

$count = 0;
$position = 50;
while ($data = trim(fgets($file))) {
    $num = (int)substr($data, 1);
    $position = $data[0] == 'L' ? $position - $num : $position + $num;
    if ($position % 100 == 0) {
        $count++;
    }
}
echo "part 1 answer: " . $count . "\n";

rewind($file);
$position = 50;
$count = 0;
while ($data = trim(fgets($file))) {
    $num = (int)substr($data, 1);
    $count += intdiv($num, 100);
    $num = $num % 100;

    if ($data[0] == 'R') {
        $direction = 1;
    } else {
        $direction = -1;
    }

    $initialPosition = $position;
    $position += $direction * $num;
    if ($initialPosition != 0 && ($position >= 100 || $position <= 0)) {
        $count++;
    }
    $position = $position % 100;
    if ($position < 0) {
        $position += 100;
    }
}

fclose($file);
echo "part 2 answer: " . $count . "\n";
