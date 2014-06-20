<?php

namespace MyWeight\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use MyWeight\Model\Statistic;
use MyWeight\Entity\Statistic;
use MyWeight\Form\StatisticForm;

class StatisticController extends AbstractActionController {

	protected $statisticTable;

	public function getStatisticTable() {
		if (!$this->statisticTable) {
			$sm = $this->getServiceLocator();
			$this->statisticTable = $sm->get('MyWeight\Model\StatisticTable');
		}
		return $this->statisticTable;
	}

	public function indexAction() {
//		return new ViewModel([
//			'statistics' => $this->getStatisticTable()->fetchAll()
//		]);
	}

	public function addAction() {

		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$statistic = new Statistic();
		$statistic->setWeight(77.7);
		$statistic->setBodyFat(9.8);
		$statistic->setBodyWater(66.5);
		$statistic->setMuscleMass(45.5);
//		$statistic->setUser();

		$objectManager->persist($statistic);
		$objectManager->flush();

		die(var_dump($statistic));


		/*		$form = new StatisticForm();
				$form->get('submit')->setValue('Add');

				if ($this->getRequest()->isPost()) {
					$statistic = new Statistic();
					$form->setInputFilter($statistic->getInputFilter());
					$form->setData($this->getRequest()->getPost());

					if ($form->isValid()) {
						$statistic->exchangeArray($form->getData());
						$this->getStatisticTable()->saveStatistic($statistic);

						return $this->redirect()->toRoute('statistic');
					}
				}
				return ['form' => $form];*/
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
}
