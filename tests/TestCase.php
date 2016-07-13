<?php

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    protected static $app;


    public function setUp()
    {
        if (! static::$app) {
            static::$app = include __DIR__ . '/../boot/start.php';
        }
    }
}