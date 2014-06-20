<?php

namespace MyWeight\Entity;

use Doctrine\ORM\Mapping as ORM;
use Users\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="Statistics")
 */
class Statistic {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Users\Entity\User", inversedBy="statistics", cascade={"remove"})
	 * @ORM\JoinColumn(name="userId", referencedColumnName="id")
	 */
	protected $user;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $date;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $weight;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $muscleMass;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $bodyFat;

	/**
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $bodyWater;

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}

	public function getUser() {
		return $this->user;
	}
	public function setUser(User $user) {
		$this->user = $user;
	}

	public function getDate() {
		return $this->date;
	}
	public function setDate($date) {
		$this->date = $date;
	}

	public function getWeight() {
		return $this->weight;
	}
	public function setWeight($weight) {
		$this->weight = $weight;
	}

	public function getMuscleMass() {
		return $this->muscleMass;
	}
	public function setMuscleMass($muscleMass) {
		$this->muscleMass = $muscleMass;
	}

	public function getBodyFat() {
		return $this->bodyFat;
	}
	public function setBodyFat($bodyFat) {
		$this->bodyFat = $bodyFat;
	}

	public function getBodyWater() {
		return $this->bodyWater;
	}
	public function setBodyWater($bodyWater) {
		$this->bodyWater = $bodyWater;
	}
}