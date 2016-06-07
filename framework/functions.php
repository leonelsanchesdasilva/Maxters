<?php

namespace Maxters;

function debug()
{
    foreach (func_get_args() as $value)
    {
        echo '<pre style="color:#fff;background-color:#222;padding:15px">';

        if (is_scalar($value))
        {
            var_dump($value);

        } else {

            print_r($value);
        }

        echo '</pre>';
    }

    exit;
}