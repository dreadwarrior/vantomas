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
     * The value modifier argument MUST be a valid json_decode()-able
     * string. It MUST contain a "var" property which goes into the getenv()
     * call and MAY contain a "prefix" or "suffix" property which then
     * prepends or appends the retrieved environment variable accordingly.
     *
     * Usage examples:
     *   - config.no_cache := readFromEnv({ "var": "TS_CONFIG_NOCACHE" })
     *   - config.cdn.replace.http.20 := readFromEnv({ "var": "TS_CONFIG_NOCACHE", "prefix": "http://" })
     *
     * @param array $parameters Contains `currentValue` and `functionArgument`
     * @param bool $reference Is set to `false` within TypoScriptParser::executeValueModifier
     *
     * @return string Returns the `currentValue` if the value modifier can not be json_decode()'d
     *                or the resulting JSON object does not contain a "var" property.
     *
     * @see TypoScriptParser::executeValueModifier
     */
    public function readFromEnvironment(array &$parameters, $reference)
    {
        $arguments = json_decode($parameters['functionArgument']);

        if (is_null($arguments) || !property_exists($arguments, 'var')) {
            return $parameters['currentValue'];
        }

        $prefix = property_exists($arguments, 'prefix') ? $arguments->prefix : '';
        $suffix = property_exists($arguments, 'suffix') ? $arguments->suffix : '';

        return $prefix . getenv($arguments->var) . $suffix;
    }
}
