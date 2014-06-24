<?php

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="users_roles")
 */
class Role {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", name="name", length=16, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\OneToMany(targetEntity="Users\Entity\User", mappedBy="users")
	 * @ORM\JoinColumn(name="roleId", referencedColumnName="id")
	 */
	protected $users;

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}

	public function getName($upperCaseFirst = true) {
		return $upperCaseFirst ? ucfirst($this->name) : $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}

	public function getUsers() {
		return $this->users;
	}
	public function setUsers($users) {
		$this->users = $users;
	}
}