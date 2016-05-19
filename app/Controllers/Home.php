<?php
namespace Maxters\Controllers;

class Home extends Controller
{
	public function index()
	{
		return $this->view('tplexample', [ 'framework' => 'Maxters' ]);
	}
}
