<?php

namespace Users\Controller;

use Users\Entity\User as UserEntity;
use Users\Filter\UserFilter;
use Users\Form\UserForm;
use Zend\Authentication\AuthenticationService;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController {

	private $userTable;
	private $entityManager;

	function indexAction() {
		return new ViewModel([
			'users' => $this->getEntityManager()->getRepository('Users\Entity\User')->findAll()
		]);
	}

	function getAction() {
		$userId = $this->params('id');

		// Trigger event
		$this->getEventManager()->trigger('get', null, ['userId' => $userId]);

		// One way
		$user = $this->getEntityManager()->find('Users\Entity\User', $userId);

		// Or another
//		$qb = $this->getEntityManager()->createQueryBuilder();
//		$qb->select('u');
//		$qb->from('Users\Entity\User', 'u');
//		$qb->leftJoin('MyWeight\Entity\Statistic', 's', 'WITH', 'u.id = s.user');
//		$qb->where('u.id = :userId');
//		$qb->setParameter('userId', $userId);
//		$q = $qb->getQuery();
//		$user = $q->getSingleResult();

		// Or another
//		$user = $this
//			->getEntityManager()
//			->createQuery('
//				SELECT u
//	    		FROM Users\Entity\User u
//	    		LEFT JOIN MyWeight\Entity\Statistic s WITH u.id = s.user
//	    		WHERE u.id = :userId
//	    	')
//			->setParameters(['userId' => $userId])
//			->getSingleResult();

		return new ViewModel([
			'user' => $user
		]);
	}

	public function loginAction() {
		$form = new UserForm();
		$form->get('submit');

		if ($this->getRequest()->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($this->getRequest()->getPost());

			if ($form->isValid()) {
				$data = $form->getData();

				$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				$adapter = $authService->getAdapter();
				$adapter->setIdentityValue($data['emailAddress']);
				$adapter->setCredentialValue($data['password']);
				$authResult = $authService->authenticate();

				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
					$authService->getStorage()->write($identity);
					if (!empty($data['rememberMe'])) {
						$time = 1209600;
						$sessionManager = new SessionManager();
						$sessionManager->rememberMe($time);
					}
					return $this->redirect()->toRoute('home');
				}
			}
		}
		return new ViewModel([
			'form' => $form
		]);
	}

	public function logoutAction() {
		$auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}
		$auth->clearIdentity();
		$sessionManager = new SessionManager();
		$sessionManager->forgetMe();
		return $this->redirect()->toRoute('home');
	}

	function addAction() {
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$userEntity = new UserEntity();
		$userEntity->setEmailAddress('baptiste@sefaireaider.com');
		$userEntity->setPassword('popo');

		$objectManager->persist($userEntity);
		$objectManager->flush();

		die(var_dump($userEntity->getId()));
	}

	function createAction() {
		$form = new UserForm();
		if ($this->getRequest()->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($this->getRequest()->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$this->getUsersTable()->insert($data);
				return $this->redirect()->toRoute('users/default', ['controller' => 'user', 'action' => 'read']);
			}
		}

		return new ViewModel([
			'form' => $form
		]);
	}

	function readAction() {
		$users = $this->getUsersTable()->select();
		return new ViewModel([
			'users' => $users
		]);
	}

	function updateAction() {
		$view = new ViewModel();
		return $view;
	}

	function deleteAction() {
		$view = new ViewModel();
		return $view;
	}

	function getUsersTable() {
		if (!$this->userTable) {
			$this->userTable = new TableGateway('Users', $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		}
		return $this->userTable;
	}


	function getEntityManager() {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->entityManager;
	}
}