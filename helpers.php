<?php


function println($string): void
{
    print($string.PHP_EOL);
}

function dd()
{
    foreach (func_get_args() as $x) {
        var_dump($x);
    }
    die;
}