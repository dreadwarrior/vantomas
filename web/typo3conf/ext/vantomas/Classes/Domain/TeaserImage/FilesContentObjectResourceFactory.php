<?php
namespace DreadLabs\Vantomas\Domain\TeaserImage;

use DreadLabs\VantomasWebsite\Page\Identifier;
use DreadLabs\VantomasWebsite\TeaserImage\Resource;
use DreadLabs\VantomasWebsite\TeaserImage\ResourceFactoryInterface;
use TYPO3\CMS\Core\TypoScript\TemplateService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\FrontendSimulatorUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Page\PageRepository;

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
        // NOTE to my future self: ContentObjectRenderer is FE-only!
        if (!isset($GLOBALS['TSFE'])) {
            FrontendSimulatorUtility::simulateFrontendEnvironment();
            $GLOBALS['TSFE']->sys_page = GeneralUtility::makeInstance(PageRepository::class);
            $GLOBALS['TSFE']->tmpl = GeneralUtility::makeInstance(TemplateService::class);
        }

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
