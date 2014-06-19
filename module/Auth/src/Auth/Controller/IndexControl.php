<?php

namespace Auth\Controller;


use Auth\Form\AuthFilter;
use Auth\Form\AuthForm;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;

class IndexController extends AbstractActionController {

	public function indexAction() {

	}

	public function loginAction() {
		$form = new AuthForm();
		$form->get('submit');

		if ($this->getRequest()->isPost()) {
			$authFilter = new AuthFilter();
			$form->setInputFilter($authFilter);
			$form->setData($this->getRequest()->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$db = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

				$config = $this->getServiceLocator()->get('Config');
				$salt = $config['static_salt'];

				$authAdapter = new AuthAdapter($db, 'auth_users', 'username', 'password', "MD5(CONCAT('$salt', ?, hash) AND active = 1");
				$authAdapter->setIdentity($data['username']);
				$authAdapter->setCredential($data['password']);

				$authService = new AuthenticationService();
				$result = $authService->authenticate($authAdapter);

				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						//
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						//
						break;

					case Result::SUCCESS:
						$storage = $authService->getStorage();
						$storage->write($authAdapter->getResultRowObject(null, 'password'));
						$time = 1209600;
						if ($data['rememberMe']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe($time);
						}
						break;

					default:
						break;
				}
			}
		}
	}
} 