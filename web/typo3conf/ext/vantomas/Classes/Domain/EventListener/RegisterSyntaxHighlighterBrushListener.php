<?php
namespace DreadLabs\Vantomas\Domain\EventListener;

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

use DreadLabs\VantomasWebsite\CodeSnippet\AbstractBrush;
use DreadLabs\VantomasWebsite\EventListener\RegisterCodeSnippetBrushListenerInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

/**
 * RegisterSyntaxHighlighterBrushListener
 *
 * Aggregates and caches SyntaxHighlighter brush identifiers
 * and the used aliases. A rendering process integrated as
 * a very last PAGE cObject can then inject the assets into
 * the page.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class RegisterSyntaxHighlighterBrushListener implements RegisterCodeSnippetBrushListenerInterface
{

    /**
     * @var FrontendInterface
     */
    private $cache;

    /**
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cache = $cacheManager->getCache('codesnippet_brushes');
    }

    /**
     * Register the given brush for deferred loading.
     *
     * @param AbstractBrush $brush
     *
     * @return void
     */
    public function handle(AbstractBrush $brush)
    {
        $brushes = [];
        $aliases = [];

        if ($this->cache->has('brushes')) {
            $brushes = (array) $this->cache->get('brushes');
        }

        if (isset($brushes[$brush->identifier])) {
            $aliases = (array) $brushes[$brush->identifier];
        }

        $aliasKeys = array_flip($aliases);

        if (!isset($aliasKeys[$brush->alias])) {
            array_push($aliases, $brush->alias);
        }

        $brushes[$brush->identifier] = $aliases;

        $this->cache->set('brushes', $brushes);
    }
}
