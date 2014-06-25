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
			],
			'login' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route' => '/login',
					'defaults' => [
						'controller' => 'Users\Controller\User',
						'action' => 'login',
					],
				],
			],
		]
	],
	'view_manager' => [
		'template_path_stack' => [
			'users' => __DIR__ . '/../view'
		],
		'display_exception' => true
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
		],
		'authentication' => [
			'orm_default' => [
				'object_manager' => 'Doctrine\ORM\EntityManager',
				'identity_class' => 'Users\Entity\User',
				'identity_property' => 'emailAddress',
				'credential_property' => 'password',
				'credential_callable' => function(Users\Entity\User $user, $givenPassword) {
					$hash = md5('a57xFokFEjx543dcdPk65asdmlkviJFdIH5c4s3547cd' . $givenPassword);
					return ($user->getPassword() === $hash && $user->getIsActive());
				}
			]
		]
	]
];