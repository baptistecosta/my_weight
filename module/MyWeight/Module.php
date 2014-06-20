<?php

namespace MyWeight;

use MyWeight\Model\Statistic;
use MyWeight\Model\StatisticTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

	public function onBootstrap(MvcEvent $e) {
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				],
			],
		);
	}

	public function getServiceConfig() {
		return [
			'factories' => [
				'MyWeight\Model\StatisticTable' => function($sm) {
					$tableGateway = $sm->get('StatisticTableGateway');
					return new StatisticTable($tableGateway);
				},
				'StatisticTableGateway' => function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Statistic());
					return new TableGateway('Statistics', $dbAdapter, null, $resultSetPrototype);
				}
			]
		];
	}
}
