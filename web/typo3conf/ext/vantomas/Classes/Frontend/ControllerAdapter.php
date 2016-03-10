<?php
namespace DreadLabs\Vantomas\Frontend;

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
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * ControllerAdapter
 *
 * Wraps the TYPO3.CMS core TypoScriptFrontendController and allows modifications of
 * it via a streamlined API for the use cases of this project.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ControllerAdapter
{

    /**
     * @var TypoScriptFrontendController
     */
    private $controller;

    public function __construct(TypoScriptFrontendController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return TypoScriptFrontendController
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns a configuration value of the TSFE->config namespace
     *
     * @param string $typoScriptPath
     * @param string $pathDelimiter
     * @param null $default Default value if value retrieval is not possible
     *
     * @return mixed|null
     */
    public function getConfig($typoScriptPath, $pathDelimiter = '/', $default = null)
    {
        try {
            $value = ArrayUtility::getValueByPath(
                $this->controller->config,
                $typoScriptPath,
                $pathDelimiter
            );
        } catch (\RuntimeException $exc) {
            $value = $default;
        }

        return $value;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->controller->content = (string) $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->controller->content;
    }
}
