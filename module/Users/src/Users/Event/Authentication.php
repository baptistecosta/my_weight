<?php
/**
 * Created by PhpStorm.
 * User: Baptiste
 * Date: 24/06/14
 * Time: 17:31
 */

namespace Users\Event;


use Users\Acl\MyAcl;
use Zend\Mvc\MvcEvent;

class Authentication {

	protected $userAuth;
	protected $aclClass;

	public function preDispatch(MvcEvent $event) {
		$serviceManager = $event->getApplication()->getServiceManager();
		$config = $serviceManager->get('config');

		$authService = $serviceManager->get('Zend\Authentication\AuthenticationService');
		$myAcl = new MyAcl($config['acl']);
		$defaultRole = MyAcl::DEFAULT_ROLE;

		if ($authService->hasIdentity()) {
			$user = $authService->getIdentity();
			$role = $user->getRole();
		}

		$routeMatch = $event->getRouteMatch();
		$controller = $routeMatch->getParam('controller');
		$action = $routeMatch->getParam('action');

		if (!$myAcl->hasResource($controller)) {
			throw new \Exception('Resource ' . $controller . ' not defined');
		}

		if (!$myAcl->isAllowed($role, $controller, $action)) {
			$url = $event->getRouter()->assemble([], ['name' => 'login']);
			$response = $event->getResponse();
			$response->headers()->addHeaderLine('Location', $url);
			$response->setStatusCode(302);
			$response->sendHeaders();
			exit;
		}
	}
} 