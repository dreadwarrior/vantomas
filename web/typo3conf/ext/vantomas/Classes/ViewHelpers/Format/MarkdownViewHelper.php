<?php
namespace DreadLabs\Vantomas\ViewHelpers\Format;

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

use Michelf\Markdown;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * MarkdownViewHelper
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class MarkdownViewHelper extends AbstractViewHelper
{

    /**
     * @var Markdown
     */
    private $parser;

    /**
     * @param Markdown $parser
     */
    public function injectMarkdownParser(Markdown $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string|null $content
     *
     * @return string
     */
    public function render($content = null)
    {
        if (is_null($content)) {
            $content = $this->renderChildren();
        }

        return $this->parser->transform($content);
    }
}
