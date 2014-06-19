<?php

namespace Auth\Adapter;


use Zend\Authentication\Adapter\AdapterInterface;

class AuthAdapter implements AdapterInterface {

	public function __construct($username, $password) {

	}

	/**
	 * Performs an authentication attempt
	 *
	 * @return \Zend\Authentication\Result
	 * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
	 */
	public function authenticate() {

	}
}