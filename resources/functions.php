<?php

namespace Maxters;

/**
 * Debug variable and values
 * 
 * @param ...$args
 * @return void
 **/
function debug()
{
    foreach (func_get_args() as $value) {
        
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

/**
 * Raise a Http Error Exception
 *
 * @throws \PHPLegends\Http\Exceptions\HttpException
 * */

function http_error($message, $statusCode = 500)
{

    if ($statusCode === 404) {

        throw new \PHPLegends\Http\Exceptions\NotFoundException($message);
    }

    throw new \PHPLegends\Http\Exceptions\HttpException($message, $statusCode);

}

/**
 * Raise a Http Error Execption if condition is TRUE
 *
 * */
function http_error_when($condition, $message, $statusCode = 500)
{
    $condition && \Maxters\http_error($message, $statusCode);
}
