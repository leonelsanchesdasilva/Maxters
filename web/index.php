<?php

$router = include __DIR__ . '/../boot/start.php';

echo $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
