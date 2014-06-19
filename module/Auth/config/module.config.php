<?php
return [
	'controllers' => [
		'invokables' => [
			'Auth\Controller\Admin' => 'Auth\Controller\AdminController',
			'Auth\Controller\Index' => 'Auth\Controller\IndexController',
			'Auth\Controller\Registration' => 'Auth\Controller\RegistrationController',
		]
	],
	'router' => [
		'routes' => [
			'auth' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/auth',
					'defaults' => [
						'__NAMESPACE__' => 'Auth\Controller',
						'controller' => 'Index',
						'action' => 'index'
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
				'paths' => [__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'Entity']
			],
			'orm_default' => [
				'drivers' => [
					'Auth\Entity' => 'application_entities'
				]
			]
		]
	]
];