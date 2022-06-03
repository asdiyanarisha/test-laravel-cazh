<?php

function encrypt($words)
{
    $encrypt_arr = [];
    $alpha_arr = str_split("abcdefghijklmnopqrstuvwxyz");
    $words_arr = str_split(strtolower($words));

    foreach ($words_arr as $key => $word) {
        // mencari indeks dari parameter huruf di array alphabet
        $index = array_search($word, $alpha_arr);
        
        $key += 1;
        if ($key % 2 == 0) {
            $index = $index - $key;          
        } else {
            $index = $index + $key;  
        }
        
        // proses jika hasil index melebihi jumlah dari alphabet
        if ($index > count($alpha_arr)) {
            $index = $index - count($alpha_arr);
        }
        
        // proses jika index menghasilkan minus
        if ($index < 0) {
            $index = count($alpha_arr) - abs($index);
        }

        array_push($encrypt_arr, $alpha_arr[$index]);
    }

    return strtoupper(join("", $encrypt_arr));
}

$word = "DFHKNQ";
echo "Input ".$word." Output ".encrypt($word)." \n";
