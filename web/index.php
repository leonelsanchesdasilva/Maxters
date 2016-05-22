<?php

$error = function ($code, $message, $filename, $line, $context = null )
{
	throw new ErrorException($message, $code, 0, $filename, $line);
};

set_error_handler($error);

$app = include __DIR__ . '/../boot/start.php';

try {

	$dispatcher = new Maxters\Dispatcher($app);

	$app['router']->dispatch($dispatcher);	

} catch (\Exception $e) {
	
	$app['response.view']('error/default', ['exception' => $e])->send();
}