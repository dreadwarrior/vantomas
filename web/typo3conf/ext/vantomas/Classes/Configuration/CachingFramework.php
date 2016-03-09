<?php
namespace DreadLabs\Vantomas\Configuration;

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

use TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend;

/**
 * CachingFramework
 *
 * Registers and configures the caches used by the extension in
 * the TYPO3.CMS caching framework.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 *
 * @see https://docs.typo3.org/typo3cms/CoreApiReference/CachingFramework/Index.html
 */
class CachingFramework
{

    public static function configure()
    {
        if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes'] = [];
        }

        if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes']['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['codesnippet_brushes']['backend'] = TransientMemoryBackend::class;
        }
    }
}
