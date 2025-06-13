<?php

$sizeMatrix = 7;

for ($baris = 0; $baris < $sizeMatrix; $baris++) {
    for ($kolom = 0; $kolom < $sizeMatrix; $kolom++) {
        if ($kolom === $baris || $kolom === ($sizeMatrix - 1 - $baris)) {
            echo 'X ';
        } else {
            echo 'O ';
        }
    }
    echo PHP_EOL; // Untuk enter
}
