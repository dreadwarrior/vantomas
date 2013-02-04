<?php
class Tx_Vantomas_Domain_Model_Page extends Tx_Extbase_DomainObject_AbstractEntity {

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
	 * @var integer
	 */
	protected $hideInNavigation;

	/**
	 *
	 * @var string
	 */
	protected $title;

	/**
	 *
	 * @var string
	 */
	protected $subtitle;

	/**
	 *
	 * @var integer
	 */
	protected $lastUpdated;

	/**
	 *
	 * @var integer
	 */
	protected $creationDate;

	/**
	 * 
	 * @var string
	 */
	protected $abstract;

	/**
	 * 
	 * @var string
	 */
	protected $media;

	/**
	 * 
	 * @var string
	 */
	protected $keywords;

	/**
	 *
	 * @param integer $hideInNavigation
	 * @return void
	 * @api
	 */
	public function setHideInNavigation($hideInNavigation) {
		$this->hideInNavigation = $hideInNavigation;
	}

	/**
	 *
	 * @return integer
	 * @api
	 */
	public function getHideInNavigation() {
		return $this->hideInNavigation;
	}

	/**
	 *
	 * @param string $title
	 * @return void
	 * @api
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 *
	 * @param string $subtitle
	 * @return void
	 * @api
	 */
	public function setSubtitle($subtitle) {
		$this->subtitle = $subtitle;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 *
	 * @param integer $lastUpdated
	 * @return void
	 * @api
	 */
	public function setLastUpdated($lastUpdated) {
		$this->lastUpdated = $lastUpdated;
	}

	/**
	 *
	 * @return integer
	 * @api
	 */
	public function getLastUpdated() {
		return $this->lastUpdated;
	}

	/**
	 *
	 * @param integer $creationDate
	 * @return void
	 * @api
	 */
	public function setCreationDate($creationDate) {
		$this->creationDate = $creationDate;
	}

	/**
	 *
	 * @return integer
	 * @api
	 */
	public function getCreationDate() {
		return $this->creationDate;
	}

	/**
	 * 
	 * @param string $abstract
	 * @return void
	 * @api
	 */
	public function setAbstract($abstract) {
		$this->abstract = $abstract;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getAbstract() {
		return $this->abstract;
	}

	/**
	 * 
	 * @param string $media
	 * @return void
	 * @api
	 */
	public function setMedia($media) {
		$this->media = $media;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getMedia() {
		return $this->media;
	}

	/**
	 * 
	 * @param string $keywords
	 * @return void
	 * @api
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getArchiveListGroupBy() {
		return strftime('%Y-%m', $this->lastUpdated);
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getArchiveMonth() {
		return strftime('%m', $this->lastUpdated);
	}

	/**
	 *
	 * @return string
	 * @api
	 */
	public function getArchiveYear() {
		return strftime('%Y', $this->lastUpdated);
	}
}
?>
