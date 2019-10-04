<?php

if (! function_exists('number_format_ari')) {
    function number_format_ari($number, $decimal = 0)
    {
        return number_format($number, $decimal, ',', '.');
    }
}

if (! function_exists('lower_camel_case')) {
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
}
