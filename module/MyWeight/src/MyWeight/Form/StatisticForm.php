<?php

namespace MyWeight\Form;

use DateTime;
use Zend\Form\Element\Date;
use Zend\Form\Form;

class StatisticForm extends Form {

	public function __construct($name = null) {
		// we want to ignore the name passed
		parent::__construct('statistic');

		$this->add([
			'name' => 'id',
			'type' => 'Hidden',
		]);

		// Date
//		$date = new \Zend\Form\Element\Date('created');
//		$date->setValue(new DateTime());
//		$date->setAttributes([
//			'class' => 'form-control input-lg',
//			'placeholder' => "Creation"
//		]);
//		$this->add($date);
		$this->add([
			'name' => 'created',
			'type' => 'Date',
			'attributes' => [
				'value' => new DateTime(),
				'class' => 'form-control input-lg',
				'placeholder' => "Creation"
			]
		]);

		$weight = new \Zend\Form\Element\Number('weight');
		$weight->setAttributes([
			'class' => 'form-control input-lg',
			'placeholder' => "Weight (kg)",
			'type' => 'number',
			'step' => 0.1
		]);
		$this->add($weight);
		$this->add([
			'name' => 'muscleMass',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Muscle Mass (%)",
				'type' => 'number',
				'step' => 0.1
			]
		]);
		$this->add([
			'name' => 'bodyFat',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Body Fat (%)",
				'type' => 'number',
				'step' => 0.1
			]
		]);
		$this->add([
			'name' => 'bodyWater',
			'type' => 'Text',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Body Water (%)",
				'type' => 'number',
				'step' => 0.1
			]
		]);
		$this->add([
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => [
				'value' => 'Go',
				'id' => 'submitButton',
				'class' => 'form-control btn-primary input-lg'
			],
		]);
	}
}