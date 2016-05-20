<?php

$app = include __DIR__ . '/../boot/start.php';

echo $app['router']->dispatch(
	new Maxters\Dispatcher($app)
);