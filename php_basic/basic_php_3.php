<?php

function cari($arr, $string)
{
    // insialisasi variabel index
    $horizontal = 0;
    $vertical = 0;

    $split_str = str_split($string);

    foreach ($split_str as $key => $str) {
        $valid = false;
        if ($key == 0) {
            // inisialisasi index huruf pertama
            $next = false;
            foreach($arr as $k => $a) {
                if (in_array($str, $a)) {
                    $horizontal = array_search($str, $a);
                    $vertical = $k;
                    $next = true;
                    break;
                }
            }
            if ($next) {
                // jika value sudah terisi maka dilanjutkan ke iterasi berikutnya
                continue;
            }
            return $valid;
        }

        // echo "str : ".$str." vertical : ".$vertical." horizontal : ".$horizontal."\n";
        
        if ($horizontal < count($arr[$vertical]) - 1) {
            if ($str == $arr[$vertical][$horizontal + 1]) {
                $horizontal = $horizontal + 1;
                $valid = true;
                continue;
            }
        }

        
        if ($vertical < count($arr) - 1) {
            if ($str == $arr[$vertical + 1][$horizontal]) {
                $vertical = $vertical + 1;
                $valid = true;
                continue;
            }
        }

        if ($horizontal > 0) {
            if ($str == $arr[$vertical][$horizontal - 1]) {
                $horizontal = $horizontal - 1;
                $valid = true;
                continue;
            }
        }

        if ($vertical > 0) {
            if ($str == $arr[$vertical - 1][$horizontal]) {
                $vertical = $vertical - 1;
                $valid = true;
                continue;
            }
        }
        return $valid;
    }
}

$arr = [
    ['f', 'g', 'h', 'i'],
    ['j', 'k', 'p', 'q'],
    ['r', 's', 't', 'u']
];

$str = "fghq";

echo "Result: '".$str."' ".json_encode(cari($arr, $str))."\n";