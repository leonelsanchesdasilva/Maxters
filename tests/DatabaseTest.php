<?php

class DatabaseTest extends TestCase
{
    public function testFind()
    {
        $data = static::$app['db']->find('Maxters\Models\User', 1);
    }

    public function test()
    {
        
    }
}