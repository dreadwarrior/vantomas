<?php
namespace DreadLabs\Vantomas\ViewHelpers;

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

use DreadLabs\VantomasWebsite\Twitter\EntityParserInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ParseTweetEntitiesViewHelper
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ParseTweetEntitiesViewHelper extends AbstractViewHelper
{

    /**
     * EntityParser impl
     *
     * @var EntityParserInterface
     */
    private $entityParser;

    /**
     * Constructor
     *
     * @param EntityParserInterface $entityParser EntityParser impl
     */
    public function __construct(EntityParserInterface $entityParser)
    {
        $this->entityParser = $entityParser;
    }

    /**
     * Initializes the VH arguments
     *
     * @return void
     * @see AbstractViewHelper::initializeArguments()
     */
    public function initializeArguments()
    {
        $this->registerArgument('entities', 'object', 'Entities of a tweet.', true);
        $this->registerArgument('urls', 'boolean', 'Flags if urls should be parsed.', false, false);
        $this->registerArgument('hashTags', 'boolean', 'Flags if hash tags should be parsed.', false, false);
    }

    /**
     * Renders the VH
     *
     * @return string
     */
    public function render()
    {
        $this->entityParser->setEntities($this->arguments['entities']);

        $tweet = $this->renderChildren();

        if ($this->arguments['urls'] === true) {
            $tweet = $this->entityParser->parseUrls($tweet);
        }

        if ($this->arguments['hashTags'] === true) {
            $tweet = $this->entityParser->parseHashTags($tweet);
        }

        return $tweet;
    }
}
