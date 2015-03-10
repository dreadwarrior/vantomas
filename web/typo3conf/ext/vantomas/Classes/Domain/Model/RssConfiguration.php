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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Holding the RSS feed configuration
 *
 * @package \DreadLabs\Vantomas\Domain\Model
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class RssConfiguration extends AbstractValueObject {

	/**
	 *
	 * @var string
	 */
	const ALLOWED_ORDER_BY_FIELDS = 'lastUpdated,sorting,title,subtitle,crdate,uid,starttime,endtime,newUntil,author,author_email';

	/**
	 *
	 * @var ContentObjectRenderer
	 */
	protected $contentObject;

	/**
	 *
	 * @var integer
	 */
	protected $startPid = 0;

	/**
	 *
	 * @var integer(1-999)
	 */
	protected $recursiveLevels = 1; // 4 -> infinite (999)

	/**
	 *
	 * @var array
	 */
	protected $doktypes = array(1); // 4 (shortcut), ...

	/**
	 *
	 * @var string
	 */
	protected $orderBy = 'lastUpdated';

	/**
	 *
	 * @var string
	 */
	protected $orderByDirection = QueryInterface::ORDER_DESCENDING;

	/**
	 *
	 * @var integer
	 */
	protected $limit = 0;

	/**
	 *
	 * @var array
	 */
	protected $treeListPageIds = array();

	/**
	 * Constructs the RSS feed generator configuration
	 *
	 * @param array $configuration
	 */
	public function __construct(array $configuration = array()) {
		if (isset($configuration['startPid'])) {
			$this->startPid = (int) $configuration['startPid'];
		}

		if (isset($configuration['recursiveLevels'])) {
			$this->recursiveLevels = MathUtility::forceIntegerInRange($configuration['recursiveLevels'], 0, 999);
		}

		if (isset($configuration['doktypes.'])) {
			$this->doktypes = (array) $configuration['doktypes.'];
		}

		if (isset($configuration['orderBy']) && GeneralUtility::inList(self::ALLOWED_ORDER_BY_FIELDS, $configuration['orderBy'])) {
			$this->orderBy = (string) $configuration['orderBy'];
		}

		if (isset($configuration['orderByDirection']) && defined($configuration['orderByDirection'])) {
			$this->orderByDirection = constant($configuration['orderByDirection']);
		}
	}

	/**
	 * Injects the configuration manager
	 *
	 * @param ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager) {
		$this->contentObject = $configurationManager->getContentObject();
	}

	/**
	 * Initializes the RssConfiguration
	 *
	 * @return void
	 * @see \TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject::initializeObject()
	 */
	public function initializeObject() {
		if ($this->startPid > 0) {
			$csvTreeListPageIds = $this->contentObject->getTreeList($this->startPid, $this->recursiveLevels);

			$this->treeListPageIds = GeneralUtility::trimExplode(',', $csvTreeListPageIds);
		}
	}

	/**
	 * Returns the tree list page ids
	 *
	 * @return array
	 */
	public function getTreeListPageIds() {
		return $this->treeListPageIds;
	}

	/**
	 * Flags if the configuration has tree list page ids set
	 *
	 * @return boolean
	 */
	public function hasTreeListPageIds() {
		return 0 < count($this->treeListPageIds);
	}

	/**
	 * Returns the available/allowed doktypes
	 *
	 * @return array
	 */
	public function getDoktypes() {
		return $this->doktypes;
	}

	/**
	 * Flags if the configuration has doktypes set
	 *
	 * @return boolean
	 */
	public function hasDoktypes() {
		return 0 < count($this->doktypes);
	}

	/**
	 * Returns the ordering configuration
	 *
	 * @return array
	 */
	public function getOrderings() {
		return array(
			$this->orderBy => $this->orderByDirection
		);
	}

	/**
	 * Returns the limit
	 *
	 * @return integer
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Flags if a query limit is set
	 *
	 * @return boolean
	 */
	public function hasLimit() {
		return 0 < $this->limit;
	}
}