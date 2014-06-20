<?php

namespace MyWeight\Controller;

use Zend\EventManager\EventManager;
use Zend\EventManager\StaticEventManager;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class SandBoxController
 * @package MyWeight\Controller
 * @author Baptiste Costa
 * @date 20/06/2014
 */
class SandBoxController extends AbstractActionController {

	function indexAction() {
		$this->getEventManager()->trigger('index', null, [
			'foo' => 'bar',
			'bat' => 'man'
		]);
	}
}