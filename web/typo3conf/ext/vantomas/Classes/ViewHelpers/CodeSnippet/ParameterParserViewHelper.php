<?php
namespace DreadLabs\Vantomas\ViewHelpers\CodeSnippet;

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

use DreadLabs\VantomasWebsite\CodeSnippet\ParameterParserInterface;
use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ParameterParserViewHelper
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ParameterParserViewHelper extends AbstractViewHelper
{
    /**
     * @var ParameterParserInterface
     */
    private $parameterParser;

    /**
     * @param ParameterParserInterface $parameterParser
     *
     * @return void
     */
    public function injectParameterParser(ParameterParserInterface $parameterParser)
    {
        $this->parameterParser = $parameterParser;
    }

    /**
     * @param string $configuration
     *
     * @return string
     */
    public function render($configuration)
    {
        return $this->parameterParser->toStringFromYaml(
            Yaml::parse($configuration)
        );
    }
}
