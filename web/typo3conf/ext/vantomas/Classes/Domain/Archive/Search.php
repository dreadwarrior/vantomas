<?php
namespace DreadLabs\Vantomas\Domain\Archive;

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

use DreadLabs\VantomasWebsite\Archive\DateRange;
use DreadLabs\VantomasWebsite\Archive\SearchInterface;
use DreadLabs\VantomasWebsite\Page\Type;

/**
 * Archive search impl
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Search implements SearchInterface
{

    /**
     * The archive search date range
     *
     * @var DateRange
     */
    private $dateRange;

    /**
     * The archive search page type
     *
     * @var Type
     */
    private $pageType;

    /**
     * Sets the search DateRange
     *
     * @param DateRange $dateRange The search DateRange
     *
     * @return void
     */
    public function setDateRange(DateRange $dateRange)
    {
        $this->dateRange = $dateRange;
    }

    /**
     * Sets the search page type
     *
     * @param Type $type The search page type
     *
     * @return void
     */
    public function setPageType(Type $type)
    {
        $this->pageType = $type;
    }

    /**
     * Returns the persistence layer query criteria
     *
     * @return array
     */
    public function getCriteria()
    {
        return [
            $this->pageType->getValue(),
            $this->dateRange->getStartDate()->getTimestamp(),
            $this->dateRange->getEndDate()->getTimestamp(),
        ];
    }

    /**
     * Returns arguments for the list/result template title rendering
     *
     * @return array
     */
    public function getResultListTitleArguments()
    {
        return [
            $this->dateRange->getStartDate()->format('Y'),
            $this->dateRange->getStartDate()->format('m'),
        ];
    }
}
