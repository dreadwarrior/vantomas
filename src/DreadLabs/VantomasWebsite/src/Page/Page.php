<?php
namespace DreadLabs\VantomasWebsite\Page;

class Page {

	/**
	 * @var PageId
	 */
	private $id;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var \DateTime
	 */
	private $lastUpdatedAt;

	/**
	 * @var string
	 */
	private $abstract;

	/**
	 * @var string
	 */
	private $subTitle;

	/**
	 * @var string
	 */
	private $keywords;

	/**
	 * @var \DateTime
	 */
	private $createdAt;

	/**
	 * @param PageId $pageId
	 */
	public function __construct(PageId $pageId) {
		$this->id = $pageId;
	}

	/**
	 * @return PageId
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param \DateTime $lastUpdatedAt
	 */
	public function setLastUpdatedAt(\DateTime $lastUpdatedAt) {
		$this->lastUpdatedAt = $lastUpdatedAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastUpdatedAt() {
		return $this->lastUpdatedAt;
	}

	/**
	 * @param string $abstract
	 */
	public function setAbstract($abstract) {
		$this->abstract = $abstract;
	}

	/**
	 * @return string
	 */
	public function getAbstract() {
		return $this->abstract;
	}

	/**
	 * @param string $subTitle
	 */
	public function setSubTitle($subTitle) {
		$this->subTitle = $subTitle;
	}

	/**
	 * @return string
	 */
	public function getSubTitle() {
		return $this->subTitle;
	}

	/**
	 * @param string $keywords
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * @return string
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt(\DateTime $createdAt) {
		$this->createdAt = $createdAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}
}