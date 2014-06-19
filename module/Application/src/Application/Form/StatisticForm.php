<?php

namespace Application\Form;

use Zend\Form\Form;

class StatisticForm extends Form {

	public function __construct($name = null) {
		// we want to ignore the name passed
		parent::__construct('statistic');

		$this->add([
			'name' => 'id',
			'type' => 'Hidden',
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
			],
			'attributes' => [
				'class' => 'form-control btn-primary input-lg'
			]
		]);
	}
}