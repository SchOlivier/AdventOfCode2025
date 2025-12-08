<?php

$filename = 'inputDay08';
// $filename = 'inputDay08.example';


$file = fopen($filename, 'r');

$cache = [];
$points = [];
while ($line = trim(fgets($file))) {
    $points[] = explode(',', $line);
}

for ($i = 0; $i < count($points); $i++) {
    for ($j = $i + 1; $j < count($points); $j++) {
        $distances["$i-$j"] = distance($points[$i], $points[$j]);
    }
}

asort($distances);

$nbGroups = 3;
$nbDistances = 1000;

$groups = [];

$count = 0;
$part2 = 0;
foreach ($distances as $key => $distance) {
    list($i, $j) = explode('-', $key);
    // echo "On check le couple $i, $j\n";
    list($a, $b) = inWhichGroup($groups, $i, $j);
    // echo "Ils sont dans les groupes " . ($a === false ? '-' : $a['groupNumber']) . ', ' . ($b === false ? '-' : $b['groupNumber']) . "\n";

    if ($a === false && $b === false) {
        $groups[] = [$i, $j];
    }

    if ($a !== false xor $b !== false) {
        if ($a !== false) {
            $groups[$a][] = $j;
        }
        if ($b !== false) {
            $groups[$b][] = $i;
        }
    }

    if ($a !== false && $b !== false && $a != $b) {
        // on merge les deux groupes.
        $groups[$a] = array_unique(array_merge($groups[$a], $groups[$b]));
        unset($groups[$b]);
    }
    // displayGroups($groups);
    // readline('next ?');
    $count++;
    if ($nbDistances == $count) answerPart1($groups, $nbGroups);
    if (count(end($groups)) == count($points)) {
        $part2 = $points[$i][0] * $points[$j][0];
        break;
    }
}

echo "Part 2 : $part2\n";

function answerPart1($groups, $nbGroups)
{
    $product = 1;
    usort($groups, fn($a, $b) => count($b) <=> count($a));
    for ($i = 0; $i < $nbGroups; $i++) {
        $product *= count($groups[$i]);
    }
    echo "Part 1 : $product\n";
}

function displayGroups(array $groups)
{
    echo "Groupes : \n";
    if (!$groups) echo "{}\n";
    foreach ($groups as $key =>  $group) {
        echo "$key : " . implode(', ', $group) . "\n";
    }
}

function distance(array $a, array $b): float
{
    return sqrt(($a[0] - $b[0]) ** 2 + ($a[1] - $b[1]) ** 2 + ($a[2] - $b[2]) ** 2);
}

function inWhichGroup(array $groups, int $i, int $j): array
{
    $a = false;
    $b = false;
    foreach ($groups as $groupNumber => $group) {
        $a = in_array($i, $group) ? $groupNumber : $a;
        $b = in_array($j, $group) ? $groupNumber : $b;
        if ($a !== false && $b !== false) break;
    }
    return [$a, $b];
}
