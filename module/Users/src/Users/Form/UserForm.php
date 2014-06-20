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
			'type' => 'Zend\Form\Element\Checkbox',
			'name' => 'rememberMe',
			'options' => [
//				'label' => 'Remember me',
				'use_hidden_element' => true,
				'checked_value' => 1,
				'unchecked_value' => 0
			]
		]);
		$this->add([
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => [
				'value' => 'Sign in',
				'id' => 'submitButton',
				'class' => 'form-control btn-primary input-lg'
			]
		]);
	}
}