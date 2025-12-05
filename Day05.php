<?php

$filename = 'inputDay05';
// $filename = 'inputDay05.example';

$file = fopen($filename, 'r');

$count = 0;
$ranges = [];
while ($data = trim(fgets($file))) {
    $ranges[] = explode('-', $data);
}
usort($ranges, function ($a, $b) {
    return $a[0] <=> $b[0];
});

// Part 2
$aggregatedRanges = [];

$countPart2 = 0;
foreach ($ranges as $range) {
    if (empty($aggregatedRanges)) {
        $aggregatedRanges[] = $range;
        continue;
    }

    $lastIndex = count($aggregatedRanges) - 1;
    $last = end($aggregatedRanges);

    if ($last[1] >= $range[0] && $last[0] <= $range[1]) {
        $aggregatedRanges[$lastIndex][0] = min($last[0], $range[0]);
        $aggregatedRanges[$lastIndex][1] = max($last[1], $range[1]);
    } else {
        $countPart2 += $last[1] - $last[0] + 1;
        $aggregatedRanges[] = $range;
    }
}
$last = end($aggregatedRanges);
$countPart2 += $last[1] - $last[0] + 1;


$count = 0;
while ($n = trim(fgets($file))) {
    foreach ($aggregatedRanges as $range) {
        if ($range[0] <= $n && $n <= $range[1]) {
            $count++;
            break;
        }
    }
}
echo "Part 1 : $count\n";
echo "Part 2 : $countPart2\n";
