<?php
namespace DreadLabs\VantomasWebsite\Twitter\AccessControl;

/**
 * "Who you are"
 */
interface AuthenticationInterface {

	/**
	 * "has a token?"
	 *
	 * @return bool
	 */
	public function isAuthenticated();

	/**
	 * @param string $attribute
	 * @return void
	 */
	public function addAttribute($attribute);

	/**
	 * Returns a string representation of authentication attributes.
	 *
	 * E.g. a username / password combination, separated by a colon.
	 *
	 * @return string
	 */
	public function toString();
}