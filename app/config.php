<?php

return [
	'debug' => true,
	'view'  => [
		'default_path'  => FRAMEWORK_PATH . '/views/',
		'extensions' => [
            'phtml' => NULL,
            'tpl'   => (unset) 'DefineYourCompile'
        ],
		'paths'     => []
	]
];