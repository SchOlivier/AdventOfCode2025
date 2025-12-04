<?php

$filename = 'inputDay04';
// $filename = 'inputDay04.example';

$file = fopen($filename, 'r');

$map = [];
while ($data = trim(fgets($file))) {
    $map[] = str_split($data);
}

$height = count($map);
$width = count($map[0]);

$count = countAccessibleRolls($map, $height, $width);

echo "Answer part 1 : $count\n";

$sum = 0;
while($count = countAccessibleRolls($map, $height, $width, true)){
    $sum += $count;
}

echo "Answer part 2 : $sum\n";

function countAccessibleRolls(array &$map, int $height, int $width, bool $updateMap = false): int
{
    $count = 0;
    for ($i = 0; $i < $height; $i++) {
        for ($j = 0; $j < $width; $j++) {
            if ($map[$i][$j] !== '@') continue;
            if (hasLessThanXNeighbours(4, $map, $i, $j)) {
                $count++;
                if ($updateMap) $map[$i][$j] = 'x';
            }
        }
    }
    return $count;
}


function hasLessThanXNeighbours(int $N, array $map, int $i, int $j): bool
{
    $count = -1;

    for ($x = $i - 1; $x <= $i + 1; $x++) {
        for ($y = $j - 1; $y <= $j + 1; $y++) {
            if (($map[$x][$y] ?? '') == '@') $count++;
            if ($count >= $N) return false;
        }
    }

    return true;
}
