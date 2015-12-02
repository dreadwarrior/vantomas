<?php
namespace DreadLabs\Vantomas\Hook\PageLayoutView;

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

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * AbstractDrawItem
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
abstract class AbstractDrawItem implements
    PageLayoutViewDrawItemHookInterface,
    DrawItemInterface
{

    /**
     * ObjectManagerInterface
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Self-registers the DrawItem hook
     *
     * @param string $extensionKey Extension key
     *
     * @return void
     */
    public static function register($extensionKey)
    {
        $className = get_called_class();

        if (($pos = strrpos($className, '\\'))) {
            $className = substr($className, $pos + 1);
        }

        $hookClassName = 'DreadLabs\\Vantomas\\Hook\\PageLayoutView\\DrawItem\\' . $className;

        $path = 'TYPO3_CONF_VARS|SC_OPTIONS|cms/layout/class.tx_cms_layout.php|tt_content_drawItem';
        $drawItems = ArrayUtility::getValueByPath($GLOBALS, $path, '|');
        $drawItems[] = $hookClassName;
        ArrayUtility::setValueByPath($GLOBALS, $path, $drawItems, '|');
    }

    /**
     * Initializes the DrawItem
     *
     * @return void
     */
    public function initialize()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * Preprocesses the preview rendering of a content element.
     *
     * @param PageLayoutView $parentObject Calling parent object
     * @param bool $drawItem Whether to draw the item using the default functionalities
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     *
     * @return void
     */
    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        if ($this->canRender($row)) {
            $drawItem = false;

            $this->initialize();
            $this->renderHeader($parentObject, $headerContent, $row);
            $this->renderContent($parentObject, $itemContent, $row);
        }
    }

    /**
     * Returns a value from the given flexform xml string
     *
     * @param string $xml The flexform XML string
     * @param string $field The field in question
     *
     * @return mixed|string
     */
    protected function getFlexformValue($xml, $field)
    {
        $data = GeneralUtility::xml2array($xml);
        $value = ArrayUtility::getValueByPath($data, 'data/sDEF/lDEF/' . $field . '/vDEF');

        return $value !== $data ? $value : 'N/A';
    }
}
