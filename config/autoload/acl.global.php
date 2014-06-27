<?php

return [
	'acl' => [
		'roles' => [
			'guest' => null,
			'registered' => 'guest',
			'admin' => 'registered'
		],
		'resources' => [
			'allow' => [
				'MyWeight\Controller\Index' => [
					'all' => [
						'guest'
					]
				],
				'MyWeight\Controller\Statistic' => [
					'index' => 'admin',
					'userStatistics' => 'registered',
					'add' => 'registered',
					'delete' => 'registered'
				],
				'Users\Controller\User' => [
					'login' => 'guest',
					'logout' => 'guest',
					'index' => 'admin',
					'get' => 'registered'
				]
			]
		]
	]
];