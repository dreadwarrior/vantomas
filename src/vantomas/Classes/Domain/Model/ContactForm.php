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

use DreadLabs\VantomasWebsite\ContactForm\Message;
use DreadLabs\VantomasWebsite\ContactForm\Person;
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
	 * @var \DreadLabs\VantomasWebsite\ContactForm\Person
	 */
	protected $person;

	/**
	 * @var \DreadLabs\VantomasWebsite\ContactForm\Message
	 */
	protected $message;

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
	 * @param Person $person
	 */
	public function setPerson(Person $person) {
		$this->person = $person;
	}

	/**
	 * @return Person
	 */
	public function getPerson() {
		return $this->person;
	}

	/**
	 * @param Message $message
	 */
	public function setMessage(Message $message) {
		$this->message = $message;
	}

	/**
	 * @return Message
	 */
	public function getMessage() {
		return $this->message;
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