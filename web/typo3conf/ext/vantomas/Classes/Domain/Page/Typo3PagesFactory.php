<?php
namespace DreadLabs\Vantomas\Domain\Page;

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
use DreadLabs\VantomasWebsite\Page\Identifier;
use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\TeaserImage\ResourceFactoryInterface;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;

/**
 * PageFactory
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Typo3PagesFactory implements FactoryInterface
{

    /**
     * @var PropertyMapper
     */
    private $mapper;

    /**
     * @var PropertyMappingConfigurationInterface
     */
    private $mapperConfiguration;

    /**
     * @var ResourceFactoryInterface
     */
    private $teaserImageResourceFactory;

    /**
     * @param PropertyMapper $propertyMapper
     *
     * @return void
     */
    public function injectPropertyMapper(PropertyMapper $propertyMapper)
    {
        $this->mapper = $propertyMapper;
    }

    /**
     * @param PropertyMappingConfigurationInterface $mapperConfiguration
     *
     * @return void
     */
    public function injectPropertyMappingConfiguration(
        PropertyMappingConfigurationInterface $mapperConfiguration
    ) {
        $this->mapperConfiguration = $mapperConfiguration;
    }

    /**
     * @param ResourceFactoryInterface $resourceFactory
     *
     * @return void
     */
    public function injectTeaserImageResourceFactory(
        ResourceFactoryInterface $resourceFactory
    ) {
        $this->teaserImageResourceFactory = $resourceFactory;
    }

    /**
     * @return void
     */
    public function initializeObject()
    {
        $this->mapperConfiguration->allowProperties(
            'identifier',
            'createdAt',
            'lastUpdatedAt',
            'title',
            'subTitle',
            'keywords',
            'abstract',
            'teaserImage'
        );
        $this->mapperConfiguration->skipUnknownProperties();

        $this->mapperConfiguration->setMapping('_pageId', 'identifier');

        $this->mapperConfiguration->setMapping('crdate', 'createdAt');
        $this->mapperConfiguration
            ->forProperty('createdAt')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                'U'
            );
        $this->mapperConfiguration->setMapping('lastUpdated', 'lastUpdatedAt');
        $this->mapperConfiguration
            ->forProperty('lastUpdatedAt')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                'U'
            );

        $this->mapperConfiguration->setMapping('title', 'title');
        $this->mapperConfiguration->setMapping('subtitle', 'subTitle');
        $this->mapperConfiguration->setMapping('keywords', 'keywords');
        $this->mapperConfiguration->setMapping('abstract', 'abstract');
        $this->mapperConfiguration->setMapping('_teaserImage', 'teaserImage');
    }

    /**
     * Builds a Page from a TYPO3.CMS `pages` associative record array
     *
     * @param array $data
     *
     * @return Page
     *
     * @throws \InvalidArgumentException
     */
    public function createFromAssociativeArray(array $data)
    {
        $identifier = Identifier::fromString($data['uid']);

        $data['_pageId'] = $identifier;

        try {
            $data['_teaserImage'] = $this->teaserImageResourceFactory->createFromPageIdentifier($identifier);
        } catch (\InvalidArgumentException $exc) {
        }

        $page = $this->mapper->convert(
            $data,
            Page::class,
            $this->mapperConfiguration
        );

        return $page;
    }
}
