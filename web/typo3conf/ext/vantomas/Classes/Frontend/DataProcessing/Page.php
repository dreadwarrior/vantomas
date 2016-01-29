<?php
namespace DreadLabs\Vantomas\Frontend\DataProcessing;

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

use DreadLabs\Vantomas\Domain\Page\Typo3PagesFactory;
use DreadLabs\VantomasWebsite\Page\FactoryInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Page
 *
 * Makes a \DreadLabs\VantomasWebsite\Page\Page object available
 * within a FLUIDTEMPLATE. Ensure, you're using this dataprocessor
 * in a FLUIDTEMPLATE context on a PAGE cObj level.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Page implements DataProcessorInterface
{

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Process content object data
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->factory = $this->objectManager->get(Typo3PagesFactory::class);

        $processedData['currentPage'] = $this->factory->createFromAssociativeArray($cObj->data);

        return $processedData;
    }
}
