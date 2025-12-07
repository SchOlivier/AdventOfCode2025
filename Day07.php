<?php

$filename = 'inputDay07';
// $filename = 'inputDay07.example';


$file = fopen($filename, 'r');


$previous = str_split(trim(fgets($file)));
$map[0] = $previous;

$count = 0;
$timelines = array_fill(0, count($previous), 0);
while ($line = str_split(trim(fgets($file)))) {
    foreach ($line as $i => $char) {
        if ($previous[$i] == 'S') {
            $line[$i] = '|';
            $timelines[$i] = 1;
        }
        if ($char == '^' && $previous[$i] == '|') {
            $count++;
            $line[$i - 1] = $line[$i + 1] = '|';
            $timelines[$i - 1] += $timelines[$i];
            $timelines[$i + 1] += $timelines[$i];
            $timelines[$i] = 0;
            continue;
        }
        if ($previous[$i] == '|') {
            $line[$i] = '|';
        }
    }
    $previous = $line;
    $map[] = $previous;
    // displayMap($map);
    // displayTimelines($timelines);
    // readline("Next?");
}


echo "Part 1 : $count\n";
echo "Part 2 : " . array_sum($timelines) . "\n";

function displayMap($map)
{
    foreach ($map as $line) {
        echo implode("", $line) . "\n";
    }
}
function displayTimeLines($timelines){
    echo implode('', $timelines) . "\n";
}
