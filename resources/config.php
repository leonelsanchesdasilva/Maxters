<?php

return [
	'debug' => true,
	'view'  => [
		'default_path'  => RESOURCES_PATH . '/views/',
		'extensions' => [
            'phtml' => NULL,
            'tpl'   => (unset) 'DefineYourCompile'
        ],
		'paths'     => []
	],

    'charset' => 'UTF-8'
];
