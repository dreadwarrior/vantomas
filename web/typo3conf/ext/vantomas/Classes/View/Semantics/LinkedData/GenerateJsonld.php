<?php
namespace DreadLabs\Vantomas\View\Semantics\LinkedData;

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

use DreadLabs\VantomasWebsite\Page\FactoryInterface;
use DreadLabs\VantomasWebsite\Page\Page;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\View\AbstractView;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * GenerateJsonld
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class GenerateJsonld extends AbstractView
{

    /**
     * @var ContentObjectRenderer
     */
    private $contentObjectRenderer;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var array
     */
    private $settings;

    /**
     * @var Page
     */
    private $page;

    /**
     * @param ContentObjectRenderer $contentObjectRenderer
     */
    public function injectContentObjectRenderer(ContentObjectRenderer $contentObjectRenderer)
    {
        $this->contentObjectRenderer = $contentObjectRenderer;
    }

    /**
     * @param FactoryInterface $factory
     *
     * @return void
     */
    public function injectFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Renders the view
     *
     * @return string The rendered view
     * @api
     */
    public function render()
    {
        $this->contentObjectRenderer->start($this->variables['data'], 'pages');
        $this->settings = $this->variables['settings'];
        $this->page = $this->factory->createFromAssociativeArray(
            $this->variables['data']
        );

        $data = [
            '@context' => [
                '@vocab' => 'https://schema.org/',
            ],
            '@type' => 'BlogPosting',
            '@id' => $this->getGlobalIdentifier(),

            'dateModified' => $this->page->getLastUpdatedAt()->format('Y-m-d'),
            'datePublished' => $this->page->getCreatedAt()->format('Y-m-d'),

            'author' => $this->getAuthor(),
            'publisher' => $this->getPublisher(),

            'headline' => $this->page->getTitle(),
            'description' => strip_tags($this->page->getAbstract()),
            'keywords' => $this->page->getKeywords(),

            'mainEntityOfPage' => [
                '@id' => $this->getGlobalIdentifier(),
            ],
        ];

        $teaserImage = $this->page->getTeaserImage();
        if (!is_null($teaserImage)) {
            $data['image'] = [
                '@type' => 'ImageObject',
                'url' => '/' . $teaserImage->getValue(),
                'width' => '546',
                'height' => '171',
            ];
        }

        return json_encode($data, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);
    }

    /**
     * @return string
     */
    private function getGlobalIdentifier()
    {
        return $this->contentObjectRenderer->typoLink(
            '',
            [
                'forceAbsoluteUrl' => true,
                'parameter' => $this->page->getIdentifier()->getValue() . ',0',
                'returnLast' => 'url',
            ]
        );
    }

    /**
     * @return array
     */
    private function getAuthor()
    {
        return [
            '@type' => 'Person',
            'name' => $this->settings['author']['name'],
        ];
    }

    /**
     * @return array
     */
    private function getPublisher()
    {
        $logoPath = GeneralUtility::getFileAbsFileName($this->settings['logoPath']);
        $logoPath = PathUtility::stripPathSitePrefix($logoPath);
        $baseUri = $this->controllerContext->getRequest()->getBaseUri();

        return [
            '@type' => 'Organization',
            'name' => $this->settings['organization']['name'],
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $baseUri . $logoPath,
            ],
        ];
    }
}
