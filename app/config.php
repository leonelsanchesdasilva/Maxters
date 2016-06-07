<?php

return [
	'debug' => false,
	'view'  => [
		'default_path'      => APP_PATH . '/Views/',
		'extensions' => [
            'phtml' => NULL,
            'tpl'   => (unset) 'DefineYourCompile'
        ],
		'paths'     => []
	]
];