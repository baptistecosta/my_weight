<?php

namespace MyWeight\Controller;

use DateTime;
use MyWeight\Filter\StatisticFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MyWeight\Entity\Statistic;
use MyWeight\Form\StatisticForm;

class StatisticController extends AbstractActionController {

	protected $entityManager;

	public function indexAction() {
		return new ViewModel([
			'statistics' => $this->getEntityManager()->getRepository('MyWeight\Entity\Statistic')->findAll()
		]);
	}

	public function userStatisticsAction() {
		$userId = $this->params('userId');
		$statisticRepo = $this->getEntityManager()->getRepository('MyWeight\Entity\Statistic');
		return new ViewModel([
			'statistics' => $statisticRepo->findBy(['user' => $userId], ['date' => 'DESC'])
		]);
	}

	public function addAction() {
		$user = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();

		$form = new StatisticForm();
		$form->get('submit')->setValue('Add');

		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			$form->setData($data);
			$form->setInputFilter(new StatisticFilter());

			if ($form->isValid()) {
				$statistic = new Statistic();
				$statistic->setDate(new DateTime($data['created']));
				$statistic->setWeight($data['weight']);
				$statistic->setBodyFatPercentage($data['bodyFat']);
				$statistic->setBodyWater($data['bodyWater']);
				$statistic->setMuscleMassPercentage($data['muscleMass']);
				$statistic->setUser($user);
				$this->getEntityManager()->persist($statistic);
				$this->getEntityManager()->flush();

				return $this->redirect()->toUrl('/users/user/get/' . $user->getId());
			}
		} else {
//			$form->get('created')->setValue((new DateTime())->format('Y-m-d'));
		}
		return ['form' => $form];
	}

	public function editAction() {
	}

	public function deleteAction() {
		$id = (int)$this->params()->fromRoute('id', 0);

		if (!$statistic = $this->getEntityManager()->find('MyWeight\Entity\Statistic', $id)) {
			return $this->redirect()->toRoute('statistic');
		}
		$this->getEntityManager()->remove($statistic);
		$this->getEntityManager()->flush();

		return $this->redirect()->toUrl($this->getRequest()->getHeader('Referer')->getUri());
	}

	function getEntityManager() {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->entityManager;
	}
}
