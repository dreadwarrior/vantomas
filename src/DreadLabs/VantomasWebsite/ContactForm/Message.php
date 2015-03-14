<?php
namespace DreadLabs\VantomasWebsite\ContactForm;

class Message {

	/**
	 *
	 * @var string
	 */
	protected $subject;

	/**
	 *
	 * @var string
	 */
	protected $message;

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
}