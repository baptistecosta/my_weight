<?php

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Console\Application;


/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 * @ORM\HasLifecycleCallbacks
 */
class User {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", name="emailAddress", length=64, nullable=false)
	 */
	protected $emailAddress;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	protected $password;

	/**
	 * @ORM\Column(type="string", length=32, nullable=false)
	 */
	protected $username;

	/**
	 * @ORM\Column(type="datetime", nullable=false)
	 */
	protected $created;

	/**
	 * @ORM\OneToMany(targetEntity="Application\Entity\Statistic", mappedBy="user", cascade={"remove"})
	 * @ORM\JoinColumn(name="userId", referencedColumnName="id")
	 */
	protected $statistics;

	/**
	 * @ORM\PrePersist
	 */
	function onPrePersist() {
		$this->created = new \DateTime();
	}

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}

	public function getEmailAddress() {
		return $this->emailAddress;
	}
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
	}

	public function getStatistics() {
		return $this->statistics;
	}
	public function setStatistics($statistics) {
		$this->statistics = $statistics;
	}

	public function getCreated() {
		return $this->created;
	}
	public function setCreated($created) {
		$this->created = $created;
	}

	public function getUsername() {
		return $this->username;
	}
	public function setUsername($username) {
		$this->username = $username;
	}
}