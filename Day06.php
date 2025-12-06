<?php

$filename = 'inputDay06';
// $filename = 'inputDay06.example';

$operators = [
    '+' => fn($a, $b) => $a + $b,
    '*' => fn($a, $b) => $a * $b
];

$file = fopen($filename, 'r');

$numbers = [];
while ($data = trim(fgets($file))) {
    $numbers[] = preg_split('/\s+/', trim($data));
}
$numbers = array_map(null, ...$numbers); // Transposition magique

$sum = 0;
foreach ($numbers as $i => $column) {
    $op = array_pop($column);
    $sum += array_reduce($column, $operators[$op], $op == '+' ? 0 : 1);
}
echo "Part 1 : $sum\n";


rewind($file);
$lastLine = `tail -n 1 $filename`;
preg_match_all('/\* +|\+ +/', $lastLine, $matches);

$nbCol = count($matches[0]);
$op = [];
$width = [];
foreach ($matches[0] as $i => $token) {
    $width[] = strlen($token);
}

$columns = [];
while ($line = trim(fgets($file), "\n\r")) {
    $pos = 0;
    for ($col = 0; $col < $nbCol; $col++) {
        $columns[$col][] = substr($line, $pos, $width[$col] - 1);
        $pos += $width[$col];
    }
}
fclose($file);

$sum = 0;
foreach ($columns as $column) {
    $op = trim(array_pop($column));
    $len = strlen($column[0]);
    $verticalNumbers = array_fill(0, $len, '');

    foreach ($column as $n) {
        for ($i = 0; $i < $len; $i++) {
            $verticalNumbers[$i] .= $n[$i];
        }
    }
    array_walk($verticalNumbers, 'trim');
    $sum += array_reduce($verticalNumbers, $operators[$op], $op == '+' ? 0 : 1);
}

echo "Sum part 2 : $sum\n";
