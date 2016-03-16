<?php
namespace DreadLabs\Vantomas\Utility;

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

use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * ArrayUtilityTrait
 *
 * This trait facilitates the handling of access to array in the $GLOBALS
 * array. The TYPO3.CMS core currently makes use of deep array paths for
 * registration of hooks and other stuff.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
trait ArrayUtilityTrait
{

    /**
     * Sets a $value on a $GLOBALS array path if not set already
     *
     * @param string $path
     * @param array $value
     * @param string $pathDelimiter
     */
    private function setGlobalArrayPathIfNotSet($path, $value = [], $pathDelimiter = '|')
    {
        if (ArrayUtility::isValidPath($GLOBALS, $path, $pathDelimiter)) {
            return;
        }

        ArrayUtility::setValueByPath($GLOBALS, $path, $value, $pathDelimiter);
    }

    /**
     * Pushes $value to a $GLOBALS array path
     *
     * @param string $path
     * @param mixed $value
     * @param string $pathDelimiter
     */
    private function pushToGlobalArrayByArrayPath($path, $value, $pathDelimiter = '|')
    {
        $currentValue = [];

        try {
            $currentValue = ArrayUtility::getValueByPath($GLOBALS, $path, $pathDelimiter);
        } catch (\RuntimeException $exc) {
            ArrayUtility::setValueByPath($GLOBALS, $path, [], $pathDelimiter);
        } finally {
            array_push($currentValue, $value);

            ArrayUtility::setValueByPath($GLOBALS, $path, $currentValue, $pathDelimiter);
        }
    }
}
