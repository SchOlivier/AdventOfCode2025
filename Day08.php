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

array_splice($distances, $nbDistances);

$groups = [];

// displayGroups($groups);
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
            $groups[$a['groupNumber']][] = $j;
        }
        if ($b !== false) {
            $groups[$b['groupNumber']][] = $i;
        }
    }

    if ($a !== false && $b !== false && $a['groupNumber'] != $b['groupNumber']) {
        // on merge les deux groupes.
        $groups[$a['groupNumber']] = array_unique(array_merge($groups[$a['groupNumber']], $groups[$b['groupNumber']]));
        unset($groups[$b['groupNumber']]);
    }
    // displayGroups($groups);
    // readline('next ?');
}

$product = 1;
usort($groups, fn($a, $b) => count($b) <=> count($a));
for($i = 0; $i < $nbGroups; $i++){
    $product *= count($groups[$i]);
}
echo "Part 1 : $product\n";

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
        $indexA = array_search($i, $group);
        $indexB = array_search($j, $group);
        if ($indexA !== false) $a = ['groupNumber' => $groupNumber, 'key' => $indexA];
        if ($indexB !== false) $b = ['groupNumber' => $groupNumber, 'key' => $indexB];
        if ($a !== false && $b !== false) break;
    }
    return [$a, $b];
}
