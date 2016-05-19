<?php
namespace Maxters\Controllers;

use PHPLegends\Legendary\View;

View::create('index', ['nome' => 'Legendary']);

abstract class Controller
{
    protected function view($name, $data)
    {
        return View::create('index', $data);
    }
}