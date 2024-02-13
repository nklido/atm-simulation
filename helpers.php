<?php


function println($string): void
{
    print($string.PHP_EOL);
}

function pressAnyKeyToContinue() {
    echo "Press Enter to continue...";
    fgets(STDIN); // Wait for the user to press Enter
}

function dd()
{
    foreach (func_get_args() as $x) {
        var_dump($x);
    }
    die;
}