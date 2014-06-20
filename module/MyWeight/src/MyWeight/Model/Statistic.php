<?php

namespace MyWeight\Model;

use Zend\InputFilter\InputFilter;

class Statistic {

	public $id;
	public $userId;
	public $date;
	public $weight;
	public $muscleMass;
	public $bodyFat;
	public $bodyWater;
	protected $inputFilter;

	public function exchangeArray($data) {
		$this->id = (!empty($data['id'])) ? $data['id'] : null;
		$this->userId = (!empty($data['userId'])) ? $data['userId'] : null;
		$this->date = (!empty($data['date'])) ? $data['date'] : null;
		$this->weight = (!empty($data['weight'])) ? $data['weight'] : null;
		$this->muscleMass = (!empty($data['muscleMass'])) ? $data['muscleMass'] : null;
		$this->bodyFat = (!empty($data['bodyFat'])) ? $data['bodyFat'] : null;
		$this->bodyWater = (!empty($data['bodyWater'])) ? $data['bodyWater'] : null;
	}

	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception("Not used");
	}

	public function getInputFilter() {
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$inputFilter->add([
				'name' => 'id',
				'required' => true,
				'filters' => [
					['name' => 'Int'],
				],
			]);
			$inputFilter->add([
				'name' => 'weight',
				'required' => true
			]);
			$inputFilter->add([
				'name' => 'muscleMass',
				'required' => true
			]);
			$inputFilter->add([
				'name' => 'bodyFat',
				'required' => true
			]);
			$inputFilter->add([
				'name' => 'bodyWater',
				'required' => true
			]);
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}