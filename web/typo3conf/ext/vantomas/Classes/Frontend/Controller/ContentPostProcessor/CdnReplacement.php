<?php
namespace DreadLabs\Vantomas\Frontend\Controller\ContentPostProcessor;

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

use DreadLabs\Vantomas\Frontend\Controller\ContentPostProcessorInterface;
use DreadLabs\Vantomas\Frontend\ControllerAdapter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * CdnReplacement
 *
 * Replaces fileadmin/, typo3conf/ and typo3temp/ resource URIs by
 * static subdomain/CDN resource URIs.
 *
 * Configuration example (TypoScript):
 *
 * page = PAGE
 * page.config {
 *   cdn {
 *     search {
 *       10 = "/fileadmin/
 *       11 = "fileadmin/
 *       20 = "/typo3conf/
 *       21 = "typo3conf/
 *       30 = "/typo3temp/
 *       31 = "typo3temp/
 *     }
 *     replace {
 *       http {
 *         10 = http://static1.example.org/
 *         11 = http://static1.example.org/
 *         20 = http://static2.example.org/
 *         21 = http://static2.example.org/
 *         30 = http://static3.example.org/
 *         31 = http://static3.example.org/
 *       }
 *       https {
 *         10 = https://static1.example.org/
 *         11 = https://static1.example.org/
 *         20 = https://static2.example.org/
 *         21 = https://static2.example.org/
 *         30 = https://static3.example.org/
 *         31 = https://static3.example.org/
 *       }
 *     }
 *   }
 * }
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class CdnReplacement implements ContentPostProcessorInterface
{

    public function modify(ControllerAdapter $controller)
    {
        $search = $controller->getConfig('config/cdn./search.', '/', []);

        $replace = $controller->getConfig('config/cdn./replace./http.', '/', []);

        // @TODO: check if this works if TYPO3 is in SSL mode behind a reverse proxy
        if (GeneralUtility::getIndpEnv('TYPO3_SSL')) {
            $replace = $controller->getConfig('config/cdn./replace./https.', '/', []);
        }

        $oldContent = $controller->getContent();
        $newContent = str_replace($search, $replace, $oldContent);

        $controller->setContent($newContent);
    }
}
