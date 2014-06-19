<?php

namespace Auth\Form;


use Zend\Form\ElementInterface;
use Zend\Form\Form;

class AuthForm extends Form {

	public function __construct($name = 'auth') {
		parent::__construct($name);

		$this->setAttribute('method', 'post');
		$this->add([
			'name' => 'username',
			'attributes' => [
				'type' => 'text'
			]
		]);
		$this->add([
			'name' => 'password',
			'attributes' => [
				'type' => 'password'
			]
		]);
		$this->add([
			'name' => 'rememberMe',
			'type' => 'checkbox'
		]);
		$this->add([
			'name' => 'submit',
			'attributes' => [
				'type' => 'submit',
				'value' => 'Log in'
			]
		]);
	}
}