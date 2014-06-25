<?php

namespace MyWeight\Controller;

use MyWeight\Filter\StatisticFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MyWeight\Entity\Statistic;
use MyWeight\Form\StatisticForm;

class StatisticController extends AbstractActionController {

	/** @deprecated */
	protected $statisticTable;

	protected $entityManager;

	public function indexAction() {
		return new ViewModel([
			'statistics' => $this->getEntityManager()->getRepository('MyWeight\Entity\Statistic')->findAll()
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
				$statistic->setWeight($data['weight']);
				$statistic->setBodyFat($data['bodyFat']);
				$statistic->setBodyWater($data['bodyWater']);
				$statistic->setMuscleMass($data['muscleMass']);
				$statistic->setUser($user);
				$this->getEntityManager()->persist($statistic);
				$this->getEntityManager()->flush();

				return $this->redirect()->toRoute('statistic');
			}
		}
		return ['form' => $form];
	}

	public function editAction() {
	}

	public function deleteAction() {
		$id = (int)$this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('statistic');
		}
		$this->getStatisticTable()->deleteStatistic($id);
		return $this->redirect()->toRoute('statistic');
	}

	function getEntityManager() {
		if (!$this->entityManager) {
			$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->entityManager;
	}

	/** @deprecated */
	public function getStatisticTable() {
		if (!$this->statisticTable) {
			$sm = $this->getServiceLocator();
			$this->statisticTable = $sm->get('MyWeight\Model\StatisticTable');
		}
		return $this->statisticTable;
	}
}
