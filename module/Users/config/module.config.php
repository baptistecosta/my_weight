<?php
return [
	'controllers' => [
		'invokables' => [
			'Users\Controller\User' => 'Users\Controller\UserController'
		]
	],
	'router' => [
		'routes' => [
			'users' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/users',
					'defaults' => [
						'__NAMESPACE__' => 'Users\Controller',
						'controller' => 'User',
						'action' => 'read'
					]
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type' => 'Segment',
						'options' => [
							'route' => '/[:controller[/:action[/:id]]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]*'
							],
							'defaults' => []
						]
					]
				]
			]
		]
	],
	'view_manager' => [
		'template_path_stack' => [
			'users' => __DIR__ . '/../view'
		]
	],
	'doctrine' => [
		'driver' => [
			'application_entities' => [
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Users' . DIRECTORY_SEPARATOR . 'Entity']
			],
			'orm_default' => [
				'drivers' => [
					'Users\Entity' => 'application_entities'
				]
			]
		]
	]
];