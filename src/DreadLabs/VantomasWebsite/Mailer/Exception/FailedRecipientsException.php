<?php
namespace DreadLabs\VantomasWebsite\Mailer\Exception;

class FailedRecipientsException extends \Exception {

	/**
	 * @var array
	 */
	private $senderList = array();

	/**
	 * @var array
	 */
	private $receiverList = array();

	/**
	 * @var array
	 */
	private $failedRecipients = array();

	/**
	 * @param string $message
	 * @param int $code
	 * @param \Exception $previous
	 */
	public function __construct($message = '', $code = 0, \Exception $previous = null) {
		parent::__construct('One or more recipients were not accepted for delivery.', 1425333667);
	}

	/**
	 * @param array $senderList
	 */
	public function setSenderList(array $senderList) {
		$this->senderList = $senderList;
	}

	/**
	 * @return array
	 */
	public function getSenderList() {
		return $this->senderList;
	}

	/**
	 * @param array $receiverList
	 */
	public function setReceiverList(array $receiverList) {
		$this->receiverList = $receiverList;
	}

	/**
	 * @return array
	 */
	public function getReceiverList() {
		return $this->receiverList;
	}

	/**
	 * @param array $failedRecipients
	 */
	public function setFailedRecipients(array $failedRecipients) {
		$this->failedRecipients = $failedRecipients;
	}

	/**
	 * @return array
	 */
	public function getFailedRecipients() {
		return $this->failedRecipients;
	}
}