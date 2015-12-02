<?php
namespace DreadLabs\Vantomas\Domain\TeaserImage;

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

use DreadLabs\VantomasWebsite\TeaserImage\LayerInterface;
use DreadLabs\VantomasWebsite\TeaserImage\CanvasInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * A TypoScript GIFBUILDER canvas
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class GifbuilderCanvas implements CanvasInterface
{

    /**
     * Layer index increment
     *
     * @var int
     */
    private static $layerIndexIncrement = 10;

    /**
     * ContentObjectRenderer
     *
     * @var ContentObjectRenderer
     */
    protected $contentObject;

    /**
     * The configuration for this canvas
     *
     * @var array
     */
    private $configuration;

    /**
     * List of layers
     *
     * @var LayerInterface[]
     */
    private $layers = array();

    /**
     * Constructor
     *
     * @param ConfigurationManagerInterface $configurationManager Application
     * ConfigurationManager
     */
    public function __construct(
        ConfigurationManagerInterface $configurationManager
    ) {
        $this->contentObject = $configurationManager->getContentObject();

        $this->initialize();
    }

    /**
     * Initializes the canvas
     *
     * @return void
     */
    public function initialize()
    {
        $this->configuration = array(
            'file' => 'GIFBUILDER',
            'file.' => array(
                'XY' => '[10.w],[10.h]',
            ),
        );
    }

    /**
     * Adds a layer to the canvas
     *
     * @param LayerInterface $layer The layer to add
     *
     * @return void
     */
    public function addLayer(LayerInterface $layer)
    {
        array_push($this->layers, $layer);
    }

    /**
     * Renders the canvas
     *
     * @return string
     */
    public function render()
    {
        foreach ($this->layers as $index => $layer) {
            $layerIndex = ($index + 1) * self::$layerIndexIncrement;
            list($layerType, $layerConfiguration) = $layer->toArray();

            $this->configuration['file.'][$layerIndex] = $layerType;
            $this->configuration['file.'][$layerIndex . '.'] = $layerConfiguration;
        }

        return $this->contentObject->cObjGetSingle('IMG_RESOURCE', $this->configuration);
    }
}
