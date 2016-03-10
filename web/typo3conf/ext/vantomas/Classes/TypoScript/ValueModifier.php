<?php
namespace DreadLabs\Vantomas\TypoScript;

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

/**
 * ValueModifier
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ValueModifier implements SingletonInterface
{

    /**
     * Register TypoScriptParser value modifiers
     *
     * Like `foo.bar := addToList()`
     *
     * @return void
     */
    public static function register()
    {
        $valueModifierHookSignature = sprintf(
            '%s->%s',
            __CLASS__,
            'readFromEnvironment'
        );

        if (!isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tsparser.php']['preParseFunc'])) {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tsparser.php']['preParseFunc'] = [];
        }

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tsparser.php']['preParseFunc']['readFromEnv'] = $valueModifierHookSignature;
    }

    /**
     * Handles the TypoScriptParser value modifier "readFromEnv".
     *
     * Usage examples:
     *   - config.no_cache := readFromEnv(TS_CONFIG_NOCACHE)
     *
     * @param array $parameters Contains `currentValue` and `functionArgument`
     * @param bool $reference Is set to `false` within TypoScriptParser::executeValueModifier
     *
     * @return string
     *
     * @see TypoScriptParser::executeValueModifier
     */
    public function readFromEnvironment(array &$parameters, $reference)
    {
        $environmentVariableName = (string) $parameters['functionArgument'];

        return getenv($environmentVariableName);
    }
}
