<?php

return [
	'controllers' => [
		'invokables' => [
			'MyWeight\Controller\Index' => 'MyWeight\Controller\IndexController',
			'MyWeight\Controller\SandBox' => 'MyWeight\Controller\SandBoxController',
			'MyWeight\Controller\Statistic' => 'MyWeight\Controller\StatisticController'
		],
	],
	'router' => [
		'routes' => [
			'home' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route' => '/',
					'defaults' => [
						'controller' => 'MyWeight\Controller\Index',
						'action' => 'index',
					],
				],
			],
			'statistic' => [
				'type' => 'segment',
				'options' => [
					'route' => '/Statistic[/][:action][/:id]',
					'constraints' => [
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+',
					],
					'defaults' => [
						'controller' => 'MyWeight\Controller\Statistic',
						'action' => 'index'
					]
				]
			],
			// The following is a route to simplify getting started creating
			// new controllers and actions without needing to create a new
			// module. Simply drop new controllers in, and you can access them
			// using the path /application/:controller/:action
			'my-weight' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/my-weight',
					'defaults' => [
						'__NAMESPACE__' => 'MyWeight\Controller',
						'controller' => 'Index',
						'action' => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type' => 'Segment',
						'options' => [
							'route' => '/[:controller[/:action]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
							'defaults' => [],
						],
					],
				],
			],
		],
	],
	'service_manager' => [
		'abstract_factories' => [
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		],
		'aliases' => [
			'translator' => 'MvcTranslator',
		],
	],
	'translator' => [
		'locale' => 'en_US',
		'translation_file_patterns' => [
			[
				'type' => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern' => '%s.mo',
			],
		],
	],
	'view_manager' => [
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => [
			'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
			'my_weight/index/index' => __DIR__ . '/../view/my_weight/index/index.phtml',
			'error/404' => __DIR__ . '/../view/error/404.phtml',
			'error/index' => __DIR__ . '/../view/error/index.phtml',
		],
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
	// Placeholder for console routes
	'console' => [
		'router' => [
			'routes' => [],
		],
	],
	'doctrine' => [
		'driver' => [
			'application_entities' => [
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'MyWeight' . DIRECTORY_SEPARATOR . 'Entity']
			],
			'orm_default' => [
				'drivers' => [
					'MyWeight\Entity' => 'application_entities'
				]
			]
		]
	]
];
