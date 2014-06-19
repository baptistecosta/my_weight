<?php

namespace Users\Form;

use Zend\InputFilter\InputFilter;

class UserFilter extends InputFilter {

	public function __construct() {
		$this->add([
			'name' => 'emailAddress',
			'required' => true,
			'filters' => [],
			'validators' => []
		]);

		$this->add([
			'name' => 'password',
			'required' => true,
			'filters' => [],
			'validators' => []
		]);
	}
}