<?php

function count_upper($str) {
    $elim = preg_replace('/[A-Z]/', "", $str);
    if ($elim == "") {
        return 0;
    }

    return count(str_split($elim));
}


$str = "Cazh";
echo "Kata ".$str." mengandung ".count_upper($str)." buah huruf kecil\n";
