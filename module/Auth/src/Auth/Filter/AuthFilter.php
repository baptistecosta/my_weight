<?php

namespace Auth\Form;

use Zend\InputFilter\InputFilter;

class AuthFilter extends InputFilter {

	public function __construct() {
		$this->add([
			'name' => 'username',
			'required' => true,
			'filters' => [
				['name' => 'StripTags'],
				['name' => 'StringTrim']
			],
			'validators' => [
				[
					'name' => 'StringLength',
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 3,
						'max' => 32
					]
				]
			]
		]);
		$this->add([
			'name' => 'password',
			'required' => true,
			'filters' => [
				['name' => 'StripTags'],
				['name' => 'StringTrim']
			],
			'validators' => [
				[
					'name' => 'StringLength',
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 4,
						'max' => 32
					]
				]
			]
		]);
	}
}