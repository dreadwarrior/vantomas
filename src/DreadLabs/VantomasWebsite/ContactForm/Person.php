<?php
namespace DreadLabs\VantomasWebsite\ContactForm;

class Person {

	/**
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $firstName;

	/**
	 *
	 * @var string
	 */
	protected $lastName;

	/**
	 *
	 * @var string
	 * @validate EmailAddress
	 */
	protected $email;

	/**
	 * Honey pot field
	 *
	 * @var string
	 */
	protected $city;

	/**
	 * Returns the firstname
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Sets the firstname
	 *
	 * @param string $firstName
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Returns the last name
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Sets the last name
	 *
	 * @param string $lastName
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Returns the email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the city
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets the city
	 *
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}
}