<?php

return [
	'acl' => [
		'roles' => [
			'regular' => null,
			'registered' => 'regular',
			'admin' => 'registered'
		],
		'resources' => [
			'allow' => [
				'Users\Controller\User' => [
					'create' => 'regular'
				]
			]
		]
	]
];