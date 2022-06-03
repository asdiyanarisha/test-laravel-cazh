<?php

$nilai = "72 65 73 78 75 74 90 81 87 65 55 69 72 78 79 91 100 40 67 77 86";
$nilai_arr = explode(" ", $nilai);

$average = array_sum($nilai_arr) / count($nilai_arr);

$lower = 0;
$higher = 0;

foreach ($nilai_arr as $numb) {
    $lower = $lower == 0 ? $numb : $lower;
    $higher = $higher == 0 ? $numb : $higher;

    $lower = $numb < $lower ? $numb : $lower;
    $higher = $numb > $higher ? $numb : $higher;
}

echo "\nResult Average ".round($average, 2);
echo "\nResult Lower ".$lower;
echo "\nResult Higher ".$higher;
echo "\n\n";


