<?php

namespace Users;

use Users\Acl\MyAcl;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;


class Module {

	public function onBootstrap(MvcEvent $e) {
		$eventManager = $e->getApplication()->getEventManager();
		$eventManager->attach('route', [$this, 'onRoute'], -100);

		$sharedEventManager = $eventManager->getSharedManager();
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

//		$sharedEventManager->attach('Zend\Mvc\Controller\ActionController', 'dispatch', [$this, 'mvcPreDispatch'], 100);
	}

	public function onRoute(MvcEvent $e) {
		$routeMatch = $e->getRouteMatch();
		$serviceManager = $e->getApplication()->getServiceManager();

		$authService = $serviceManager->get('Zend\Authentication\AuthenticationService');
		$myAcl = new MyAcl($serviceManager->get('Config'));

		$role = MyAcl::DEFAULT_ROLE;

		if ($authService->hasIdentity()) {
			$user = $authService->getIdentity();
			$role = $user->getRole()->getName();
		}
		$controller = $routeMatch->getParam('controller');
		$action = $routeMatch->getParam('action');

		if (!$myAcl->hasResource($controller)) {
			throw new \Exception('Resource ' . $controller . ' not defined');
		}
		if (!$myAcl->isAllowed($role, $controller, $action)) {
			$url = $e->getRouter()->assemble([], ['name' => 'login']);
			$response = $e->getResponse();
			$response->getHeaders()->addHeaderLine('Location', $url);
			$response->setStatusCode(302);
			$response->sendHeaders();
			exit;
		}
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
