<?php
class Tx_Vantomas_Domain_Model_Comment extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 *
	 * @var Tx_Vantomas_Domain_Repository_PageRepository
	 */
	protected $pageRepository = NULL;

	/**
	 * uid
	 * @var int
	 * @validate NotEmpty
	 */
	protected $uid;

	/**
	 * pid
	 * @var int
	 * @validate NotEmpty
	 */
	protected $pid;

	/**
	 * 
	 * @var boolean
	 */
	protected $approved;

	/**
	 * external_ref
	 * @var string
	 */
	protected $externalReference;

	/**
	 * external_prefix
	 * @var string
	 */
	protected $externalPrefix;

	/**
	 *
	 * @var string
	 */
	protected $firstname;

	/**
	 *
	 * @var string
	 */
	protected $lastname;

	/**
	 *
	 * @var string
	 */
	protected $email;

	/**
	 *
	 * @var string
	 */
	protected $homepage;

	/**
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * 
	 * @param Tx_Vantomas_Domain_Repository_PageRepository $pageRepository
	 * @return void
	 */
	public function injectPageRepository(Tx_Vantomas_Domain_Repository_PageRepository $pageRepository) {
		$this->pageRepository = $pageRepository;
	}

	/**
	 *
	 * @param boolean $approved
	 * @return void
	 * @api
	 */
	public function setApproved($approved) {
		$this->approved = $approved;
	}

	/**
	 *
	 * @return boolean
	 * @api
	 */
	public function getApproved() {
		return $this->approved;
	}

	/**
	 *
	 * @param string $externalReference
	 * @return void
	 * @api
	 */
	public function setExternalReference($externalReference) {
		$this->externalReference = $externalReference;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getExternalReference() {
		return $this->externalReference;
	}
	
	/**
	 *
	 * @param string $externalPrefix
	 * @return void
	 * @api
	 */
	public function setExternalPrefix($externalPrefix) {
		$this->externalPrefix = $externalPrefix;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getExternalPrefix() {
		return $this->externalPrefix;
	}

	/**
	 *
	 * @param string $firstname
	 * @return void
	 * @api
	 */
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getFirstname() {
		return $this->firstname;
	}

	/**
	 *
	 * @param string $lastname
	 * @return void
	 * @api
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 *
	 * @param string $email
	 * @return void
	 * @api
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 *
	 * @param string $homepage
	 * @return void
	 * @api
	 */
	public function setHomepage($homepage) {
		$this->homepage = $homepage;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getHomepage() {
		return $this->homepage;
	}

	/**
	 *
	 * @param string $content
	 * @return void
	 * @api
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 *
	 * @return Tx_Vantomas_Domain_Model_Page
	 */
	public function getPage() {
		return $this->pageRepository->findOneByUid($this->pid);
	}
}
?>