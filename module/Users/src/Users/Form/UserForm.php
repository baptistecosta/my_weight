<?php

namespace Users\Form;

use Zend\Form\Form;

class UserForm extends Form {

	public function __construct($name = null) {
		parent::__construct('user');
		$this->setAttribute('method', 'post');
		$this->add([
			'name' => 'id',
			'type' => 'Hidden',
		]);
		$this->add([
			'name' => 'emailAddress',
			'type' => 'Text',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Email address"
			]
		]);
		$this->add([
			'name' => 'password',
			'type' => 'password',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Password"
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