<?php
namespace DreadLabs\Vantomas\Hook;

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

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Hook class for TypoScriptFrontendController
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TypoScriptFrontendControllerHook implements SingletonInterface
{

    /**
     * Configuration for this hook
     *
     * @var array
     */
    protected $config = [];

    /**
     * Replacement for static subdomain/CDN ressources
     *
     * Hooks into `tslib/class.tslib_fe.php::contentPostProc-all`.
     *
     * @param array $parameters Only contains one item:
     *                          `pObj` which is a reference to $parentObject
     * @param TypoScriptFrontendController $parentObject Application TSFE
     *
     * @return void
     */
    public function interceptCdnReplacements(
        array $parameters = [],
        TypoScriptFrontendController &$parentObject
    ) {
        $this->config = $parentObject->config['config']['cdn.'];

        $search = $this->config['search.'];

        $replace = $this->config['replace.']['http.'];

        // @todo: check if this works if TYPO3 is in SSL mode behind a reverse proxy
        if (GeneralUtility::getIndpEnv('TYPO3_SSL')) {
            $replace = $this->config['replace.']['https.'];
        }

        $parentObject->content = str_replace(
            $search,
            $replace,
            $parentObject->content
        );
    }
}
