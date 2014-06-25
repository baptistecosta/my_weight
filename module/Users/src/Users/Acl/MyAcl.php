<?php

namespace Users\Acl;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;

class MyAcl extends Acl {

	const DEFAULT_ROLE = 'guest';

	public function __construct($config) {
		if (!isset($config['acl']['roles']) || !isset($config['acl']['resources'])) {
			throw new \Exception('Invalid ACL Config found');
		}

		if (!isset($config['acl']['roles'][self::DEFAULT_ROLE])) {
			$config['acl']['roles'][self::DEFAULT_ROLE] = '';
		}

		$this->addRoles($config['acl']['roles']);
		$this->addResources($config['acl']['resources']);
	}

	protected function addRoles($roles) {
		foreach ($roles as $name => $parent) {
			if (!$this->hasRole($name)) {
				$parent = empty($parent) ? [] : explode(',', $parent);
				$this->addRole(new GenericRole($name), $parent);
			}
		}
		return $this;
	}

	protected function addResources($resources) {
		foreach ($resources as $permission => $controllers) {
			foreach ($controllers as $controller => $actions) {
				if ($controller == 'all') {
					$controller = null;
				} else {
					if (!$this->hasResource($controller)) {
						$this->addResource(new GenericResource($controller));
					}
				}

				foreach ($actions as $action => $role) {
					if ($action == 'all') {
						$action = null;
					}

					switch ($permission) {
						case 'allow':
							$this->allow($role, $controller, $action);
							break;

						case 'deny':
							$this->deny($role, $controller, $action);
							break;

						default:
							throw new \Exception('No valid permission defined: ' . $permission);
					}
				}
			}
		}
		return $this;
	}
}