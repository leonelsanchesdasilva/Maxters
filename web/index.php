<?php

set_error_handler(function ($code, $message, $filename, $line, $context = null)
{
	throw new ErrorException($message, $code, 0, $filename, $line);
});

$app = include __DIR__ . '/../boot/start.php';

try {

	$dispatcher = new Maxters\Dispatcher($app);

	$app['router']->dispatch($dispatcher);	

} catch (\Exception $e) {
	
	echo $app['view']->create('error/default', ['exception' => $e]);
}