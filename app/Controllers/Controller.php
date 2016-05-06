<?php

namespace Maxters\Controllers;

use PHPLegends\View\View;

abstract class Controller
{
	protected function render($name, $data)
	{
		$path = APP_PATH . '/Views/';

		return new View($name, $data, $path, 'phtml');
	}
}