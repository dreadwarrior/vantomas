<?php
namespace DreadLabs\Vantomas\ViewHelpers\Page;

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

use DreadLabs\Vantomas\Domain\TeaserImage\FoldedPaperWithGrungeCanvasFactory;
use DreadLabs\VantomasWebsite\Page\Page;
use DreadLabs\VantomasWebsite\TeaserImage\CanvasFactoryInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A page teaser image generator view helper which makes use of TypoScript cObj
 * IMG_RESOURCE & GIFBUILDER configuration.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class TeaserImageViewHelper extends AbstractViewHelper
{

    /**
     * Initializes the VH arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'page',
            Page::class,
            'Page from which to render the image out of the `media` field.',
            true
        );
    }

    /**
     * Renders the VH
     *
     * @return string ready-to-use <img /> src-Attribute
     */
    public function render()
    {
        return $this->getCanvasFactory()->create(
            $this->getPageFromArguments()->getTeaserImage()->getValue()
        )->render();
    }

    /**
     * Returns a CanvasFactory impl
     *
     * @return CanvasFactoryInterface
     */
    private function getCanvasFactory()
    {
        return $this->objectManager->get(FoldedPaperWithGrungeCanvasFactory::class);
    }

    /**
     * Returns the Page given to the VH arguments
     *
     * @return Page
     */
    private function getPageFromArguments()
    {
        return $this->arguments['page'];
    }
}
