<?php

namespace Users\Controller;

use Users\Form\UserFilter;
use Users\Form\UserForm;
use Users\Entity\User as UserEntity;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController {

	private $userTable;
	private $entityManager;

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

	function indexAction() {
		return new ViewModel([
			'users' => $this->getEntityManager()->getRepository('Users\Entity\User')->findAll()
		]);
	}

	function getAction() {
		$userId = $this->params('id');

		// One way
		$user = $this->getEntityManager()->find('Users\Entity\User', $userId);

		// Or another
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb->select('u');
		$qb->from('Users\Entity\User', 'u');
		$qb->leftJoin('Application\Entity\Statistic', 's', 'WITH', 'u.id = s.user');
		$qb->where('u.id = :userId');
		$qb->setParameter('userId', $userId);
		$q = $qb->getQuery();
		$user = $q->getSingleResult();

		// Or another
		$user = $this
			->getEntityManager()
			->createQuery('
				SELECT u
	    		FROM Users\Entity\User u
	    		LEFT JOIN Application\Entity\Statistic s WITH u.id = s.user
	    		WHERE u.id = :userId
	    	')
			->setParameters(['userId' => $userId])
			->getSingleResult();

		return new ViewModel([
			'user' => $user
		]);
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
}