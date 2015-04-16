<?php
namespace DreadLabs\Vantomas\Tests\Unit\Domain\Archive;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DreadLabs\Vantomas\Domain\Archive\Search;
use DreadLabs\VantomasWebsite\Archive\DateRange;
use DreadLabs\VantomasWebsite\Page\PageType;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * TestCase for the Archive Search
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SearchTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var TypoScriptFrontendController|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $typoScriptFrontendControllerMock;

	/**
	 * @var DateRange|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $dateRangeMock;

	/**
	 * @var PageType|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $pageTypeMock;

	/**
	 * @var Search
	 */
	protected $sut;

	public function setUp() {
		$this->typoScriptFrontendControllerMock = $this->getMock(TypoScriptFrontendController::class);
		$GLOBALS['TSFE'] = $this->typoScriptFrontendControllerMock;

		$this->dateRangeMock = $this->getMockBuilder(DateRange::class)->disableOriginalConstructor()->getMock();

		$this->pageTypeMock = $this->getMockBuilder(PageType::class)->disableOriginalConstructor()->getMock();

		$this->sut = new Search();
		$this->sut->setDateRange($this->dateRangeMock);
		$this->sut->setPageType($this->pageTypeMock);
	}

	public function testCurrentPageProxiesTypoScriptFrontendController() {
		$this->typoScriptFrontendControllerMock->page = 'FOOBAR';

		$currentPage = $this->sut->getCurrentPage();

		$this->assertEquals('FOOBAR', $currentPage);
	}

	public function testCriteriaContainPageTypeAndDateRangeValues() {
		$this->pageTypeMock->expects($this->once())->method('getValue')->will($this->returnValue('blog'));
		$startDate = new \DateTime('01.04.2015');
		$this->dateRangeMock->expects($this->once())->method('getStartDate')->will($this->returnValue($startDate));
		$endDate = new \DateTime('30.04.2015');
		$this->dateRangeMock->expects($this->once())->method('getEndDate')->will($this->returnValue($endDate));

		$criteria = $this->sut->getCriteria();

		$this->assertSame(array('blog', $startDate->getTimestamp(), $endDate->getTimestamp()), $criteria);
	}

	public function testPageTitleArgumentsContainYearAndMonthOfStartDate() {
		$startDate = new \DateTime('16.04.2015');
		$this->dateRangeMock->expects($this->exactly(2))->method('getStartDate')->will($this->returnValue($startDate));

		$titleArguments = $this->sut->getResultListTitleArguments();

		$this->assertSame(array('2015', '04'), $titleArguments);
	}

	public function testResultCount() {
		$result = array('foo', 'bar', 'hello', 'world');
		$this->sut->setResult($result);

		$count = $this->sut->count();

		$this->assertSame(4, $count);
	}

	public function testResultIterator() {
		$result = array('foo', 'bar', 'hello', 'world');
		$this->sut->setResult($result);

		$actualResult = array();
		foreach ($this->sut as $resultItem) {
			$actualResult[] = $resultItem;
		}

		$this->assertSame($result, $actualResult);
	}
}