<?php

namespace MyWeight\Entity;

use Doctrine\ORM\Mapping as ORM;
use Users\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="statistics")
 * @ORM\HasLifecycleCallbacks
 */
class Statistic {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Users\Entity\User", inversedBy="statistics")
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

	/**
	 * @ORM\PrePersist
	 */
	function onPrePersist() {
//		$this->date = new \DateTime();
	}

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

	public function getMuscleMassPercentage() {
		return $this->muscleMass;
	}
	public function setMuscleMassPercentage($muscleMass) {
		$this->muscleMass = $muscleMass;
	}
	public function getMuscleMass() {
		return $this->muscleMass * $this->weight / 100;
	}

	public function getBodyFatPercentage() {
		return $this->bodyFat;
	}
	public function getBodyFat() {
		return $this->bodyFat * $this->weight / 100;
	}
	public function setBodyFatPercentage($bodyFat) {
		$this->bodyFat = $bodyFat;
	}

	public function getBodyWater() {
		return $this->bodyWater;
	}
	public function setBodyWater($bodyWater) {
		$this->bodyWater = $bodyWater;
	}
}