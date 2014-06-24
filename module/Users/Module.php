<?php

namespace Users;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;


class Module {

	public function onBootstrap(MvcEvent $e) {
		$sharedEventManager = $e->getApplication()->getEventManager()->getSharedManager();
//		$sharedEventManager->attach('Users\Controller\UserController', 'get', function($e) {
//			var_dump($e);
//		}, 100);

//		$sharedEventManager->attach('MyWeight\Controller\SandBoxController', 'index', function($e) {
//			$eventName = $e->getName();
//			$eventParams = $e->getParams();
//			var_dump('Handled event "%s", with parameters %s', $eventName, json_encode($eventParams));
//		});

		$sharedEventManager->attach(['Users\Controller\UserController', 'MyWeight\Controller\SandBoxController'], ['get', 'index'], function($e) {
			$eventName = $e->getName();
			$eventParams = $e->getParams();
//			var_dump([$eventName, $eventParams]);
		});
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return [
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				],
			],
		];
	}

	public function getServiceConfig() {
		return [
			'factories' => [
				'Zend\Authentication\AuthenticationService' => function($serviceManager) {
					return $serviceManager->get('doctrine.authenticationservice.orm_default');
				}
			]
		];
	}
}
