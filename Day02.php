<?php

$filename = 'inputDay02';
// $filename = 'inputDay02.example';

$data = file_get_contents($filename);
$ranges = explode(',', $data);

$sum1 = 0;
$sum2 = 0;
foreach ($ranges as $range) {
    $n = explode('-', $range);
    $min = $n[0];
    $max = $n[1];
    // $sum1 += array_sum(getInvalidIds1($min, $max));
    $sum2 += array_sum(getInvalidIds2($min, $max));
}

echo "Result part 1: $sum1\n";
echo "Result part 1: $sum2\n";

function getInvalidIds1(int $min, int $max): array
{
    $ids = [];
    for ($i = $min; $i <= $max; $i++) {
        $len = strlen($i);
        if ($len % 2 == 1) continue;

        if (substr($i, 0, $len / 2) == substr($i, $len / 2)) $ids[] = $i;
    }
    return $ids;
}

function getInvalidIds2(int $min, int $max): array
{
    $ids = [];
    for ($i = $min; $i <= $max; $i++) {
        // echo "-----\non check $i\n";
        $str = (string)$i;
        $len = strlen($str);
        $lenSeq = 1;
        while ($lenSeq <= $len / 2) {
            if (intdiv($len, $lenSeq) != $len / $lenSeq) {
                $lenSeq++;
                continue;
            }
            $isId = true;
            $seq = substr($str, 0, $lenSeq);
            // echo "seq: $seq\n";
            for ($pos = $lenSeq; $pos + $lenSeq <= $len; $pos += $lenSeq) {
                $substr = substr($str, $pos, $lenSeq);
                // echo "substr : $substr\n";
                if ($seq == $substr) continue;
                $isId = false;
                break;
            }
            if ($isId) {
                // echo "$i\n";
                $ids[] = $i;
                continue(2);
            }
            $lenSeq++;
        }
    }
    return $ids;
}
