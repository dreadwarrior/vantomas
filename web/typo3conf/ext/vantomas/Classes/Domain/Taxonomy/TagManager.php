<?php
namespace DreadLabs\Vantomas\Domain\Taxonomy;

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

use DreadLabs\VantomasWebsite\Page\RepositoryInterface;
use DreadLabs\VantomasWebsite\Taxonomy\Tag;
use DreadLabs\VantomasWebsite\Taxonomy\TagCloudInterface;
use DreadLabs\VantomasWebsite\Taxonomy\TagManagerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides access to the tag taxonomy layer
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TagManager implements TagManagerInterface
{

    /**
     * Page repository, gateway to the persistance layer
     *
     * @var RepositoryInterface
     */
    private $pageRepository;

    /**
     * TagCloud impl
     *
     * @var TagCloudInterface
     */
    private $tagCloud;

    /**
     * Constructor
     *
     * @param RepositoryInterface $pageRepository Page repository impl
     * @param TagCloudInterface $tagCloud TagCloud impl
     */
    public function __construct(
        RepositoryInterface $pageRepository,
        TagCloudInterface $tagCloud
    ) {
        $this->pageRepository = $pageRepository;
        $this->tagCloud = $tagCloud;
    }

    /**
     * Returns a TagCloud impl
     *
     * @return TagCloudInterface
     */
    public function getCloud()
    {
        $pages = $this->pageRepository->findAllWithTags();

        foreach ($pages as $page) {
            $pageTags = GeneralUtility::trimExplode(',', $page->getKeywords());
            foreach ($pageTags as $pageTag) {
                $this->tagCloud->add(Tag::fromString($pageTag));
            }
        }

        return $this->tagCloud;
    }
}
