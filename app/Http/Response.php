<?php

namespace Maxters\Http;

use PHPLegends\Http\Response as BaseResponse;

class Response extends BaseResponse
{
    public static function create($content, $code = 200, Closure $callback = null)
    {
        $response = new static($content, $code);

        $callback && $callback($response);

        return $response;
    }
}