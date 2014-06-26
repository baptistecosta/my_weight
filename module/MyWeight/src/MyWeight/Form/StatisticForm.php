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
//		$date = new Date('created');
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
		$this->add([
			'name' => 'weight',
			'type' => 'Text',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Weight (kg)"
			]
		]);
		$this->add([
			'name' => 'muscleMass',
			'type' => 'Text',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Muscle Mass (%)"
			]
		]);
		$this->add([
			'name' => 'bodyFat',
			'type' => 'Text',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Body Fat (%)"
			]
		]);
		$this->add([
			'name' => 'bodyWater',
			'type' => 'Text',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Body Water (%)"
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