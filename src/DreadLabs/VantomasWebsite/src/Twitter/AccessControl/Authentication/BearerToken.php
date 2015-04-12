<?php
namespace DreadLabs\VantomasWebsite\Twitter\AccessControl\Authentication;

use DreadLabs\VantomasWebsite\Twitter\AccessControl\AuthenticationInterface;

class BearerToken implements AuthenticationInterface {

	/**
	 * @var array
	 */
	private $attributes = array();

	public function isAuthenticated() {
		return !empty($this->attributes);
	}

	public function addAttribute($attribute) {
		array_push($this->attributes, $attribute);
	}

	public function toString() {
		return implode('', $this->attributes);
	}
}