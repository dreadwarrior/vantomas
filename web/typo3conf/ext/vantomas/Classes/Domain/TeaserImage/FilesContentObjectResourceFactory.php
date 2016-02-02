<?php
namespace DreadLabs\Vantomas\Domain\TeaserImage;

use DreadLabs\VantomasWebsite\Page\Identifier;
use DreadLabs\VantomasWebsite\TeaserImage\Resource;
use DreadLabs\VantomasWebsite\TeaserImage\ResourceFactoryInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class FilesContentObjectResourceFactory implements ResourceFactoryInterface
{

    /**
     * @var ContentObjectRenderer
     */
    private $contentObjectRenderer;

    public function __construct(ContentObjectRenderer $cObjectRenderer)
    {
        $this->contentObjectRenderer = $cObjectRenderer;
    }

    /**
     * Resolves the base image resource string
     *
     * This method ensures that the page overlays, translations etc.
     * will be loaded by the TYPO3.CMS core for the specified field.
     *
     * @param Identifier $identifier
     *
     * @return Resource
     */
    public function createFromPageIdentifier(Identifier $identifier)
    {
        $configuration = [
            'references.' => [
                'table' => 'pages',
                'uid' => $identifier->getValue(),
                'fieldName' => 'media',
            ],
            'begin' => 0,
            'maxItems' => 1,
            'renderObj' => 'TEXT',
            'renderObj.' => [
                'stdWrap.' => [
                    'data' => 'file:current:publicUrl',
                ],
            ],
        ];

        return Resource::createFromPublicUrl(
            $this->contentObjectRenderer->cObjGetSingle('FILES', $configuration)
        );
    }
}
