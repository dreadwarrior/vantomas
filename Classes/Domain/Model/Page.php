<?php
namespace Dreadwarrior\Vantomas\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Page gives access to pages records
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Page extends AbstractEntity {

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
