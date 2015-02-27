<?php
namespace DreadLabs\Vantomas\Domain\Model;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/**
 * The contact form domain object
 *
 * @package \DreadLabs\Vantomas\Domain\Model
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class ContactForm extends AbstractValueObject {

	/**
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $subject;

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
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $message;

	/**
	 * Honey pot field
	 *
	 * @var string
	 */
	protected $city;

	/**
	 *
	 * @var \DateTime
	 * @validate NotEmpty
	 */
	protected $creationDate;

	/**
	 * Constructs the ContactForm
	 */
	public function __construct() {
		$this->creationDate = new \DateTime();
	}

	/**
	 * Returns the subject
	 *
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Sets the subject
	 *
	 * @param string $subject
	 * @return void
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

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
	 * Returns the message
	 *
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets the message
	 *
	 * @param string $message
	 * @return void
	 */
	public function setMessage($message) {
		$this->message = $message;
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

	/**
	 * Returns the creation date
	 *
	 * @return \DateTime
	 */
	public function getCreationDate() {
		return $this->creationDate;
	}

	/**
	 * Sets the creation date
	 *
	 * @param \DateTime $creationDate
	 * @return void
	 */
	public function setCreationDate(\DateTime $creationDate) {
		$this->creationDate = $creationDate;
	}
}