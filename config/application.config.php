<?php

return [
	'modules' => [
		'ZendDeveloperTools',
		'DoctrineModule',
		'DoctrineORMModule',
		'Application',
		'Users'
	],
	'module_listener_options' => [
		'module_paths' => [
			'./module',
			'./vendor'
		],
		'config_glob_paths' => ['config/autoload/{,*.}{global,local}.php']
	]
];
