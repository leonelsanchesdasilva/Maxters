<?php

set_error_handler(function ($code, $message, $filename, $line, $context = null)
{
	throw new ErrorException($message, $code, 0, $filename, $line);
});

$app = include __DIR__ . '/../boot/start.php';

set_exception_handler(function ($exception) use($app)
{
    $handle = new Maxters\Exceptions\Handle($app);

    return $handle->render($exception);
});

$dispatcher = new Maxters\Dispatcher($app);

$app['router']->dispatch($dispatcher);
