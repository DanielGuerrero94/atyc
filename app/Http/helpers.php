<?php

function number_format_ari($number, $decimal = 0)
{
    return number_format($number, $decimal, ',', '.');
}

function lower_camel_case($string)
{
    $string = preg_replace_callback(
        '/_(.?)/',
        function ($matches) {
            foreach ($matches as $match) {
                return strtoupper($match);
            }
        },
        $string
    );

    return preg_replace('/_/', '', $string);
}
