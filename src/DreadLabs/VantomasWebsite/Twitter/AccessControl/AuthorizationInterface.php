<?php
namespace DreadLabs\VantomasWebsite\Twitter\AccessControl;

use DreadLabs\VantomasWebsite\Twitter\AccessControl\Exception\AuthorizationFailedException;

/**
 * "What you are authorized to do"
 */
interface AuthorizationInterface {

	/**
	 * Sets credentials on AuthenticationInterface
	 *
	 * @param AuthenticationInterface $authentication
	 * @return void
	 * @throws AuthorizationFailedException
	 */
	public function authorize(AuthenticationInterface $authentication);
}