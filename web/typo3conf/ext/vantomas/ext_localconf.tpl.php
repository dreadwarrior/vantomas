<?php
defined('TYPO3_MODE') or die();

\FluidTYPO3\Flux\Core::registerProviderExtensionKey(
	'DreadLabs.Vantomas',
	'Page'
);
\FluidTYPO3\Flux\Core::registerProviderExtensionKey(
	'DreadLabs.Vantomas',
	'Content'
);

if (TYPO3_MODE == 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:vantomas/Configuration/TSConfig/page.ts">'
	);
}
// -- feature: RTE 4 abstract

$extConf = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['vantomas']);

\DreadLabs\Vantomas\Utility\ExtensionManagement\PageAbstractRte::configure($extConf);

// -- archive plugins

// -- 1. archive list

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveList',
	array(
		'Archive\\List' => 'show'
	),
	array()
);

// -- 2. archive search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveSearch',
	array(
		'Archive\\Search' => 'show'
	),
	array()
);

// -- last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'SiteLastUpdatedPages',
	array(
		'Site\\LastUpdatedPages' => 'list'
	),
	array()
);

\DreadLabs\Vantomas\Hook\PageLayoutView\DrawItem\SiteLastUpdatedPages::register($_EXTKEY);

// -- comment plugins

// -- 1. latest disqus comments

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'DisqusLatest',
	array(
		'SocialNetworking\\Disqus' => 'latest'
	),
	array()
);

// -- twitter plugins

// -- 1. timeline tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterTimeline',
	array(
		'SocialNetworking\\Twitter' => 'timeline'
	),
	array()
);

// -- 2. search tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterSearch',
	array(
		'SocialNetworking\\Twitter' => 'search'
	),
	array()
);

// -- tag cloud/search plugins

// -- 1. tag cloud

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagCloud',
	array(
		'Taxonomy\\TagCloud' => 'show'
	),
	array()
);

// -- 2. tag search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagSearch',
	array(
		'Taxonomy\\TagSearch' => 'list'
	),
	array()
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ContactForm',
	array(
		'Form\\Contact' => 'new, send, success',
	),
	array(
		'Form\\Contact' => 'new, send, success',
	)
);

// -- RSS feed

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'RssFeed',
	array(
		'Semantics\\RssFeed' => 'generate'
	),
	array()
);

// -- sitemap.xml

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'SitemapXml',
	array(
		'Semantics\\SitemapXml' => 'generate'
	),
	array()
);

// -- secret santa

\TYPO3\CMS\Extbase\Utility\Extensionutility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'SecretSantaAccessControl',
	array(
		'SecretSanta\\AccessControl' => 'form,login,logout',
	),
	array(
		'SecretSanta\\AccessControl' => 'form,login,logout',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'SecretSantaRevealDonee',
	array(
		'SecretSanta\\RevealDonee' => 'show',
	),
	array(
		'SecretSanta\\RevealDonee' => 'show',
	)
);

/* @var $signalSlotDispatcher \TYPO3\CMS\Extbase\SignalSlot\Dispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
	\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

// -- register contact form mailing handler
$signalSlotDispatcher->connect(
	\DreadLabs\Vantomas\Controller\Form\ContactController::class,
	'send',
	\DreadLabs\VantomasWebsite\Mail\Carrier::class,
	'convey'
);

// -- register secret santa donor/donee pair persister
$signalSlotDispatcher->connect(
	\DreadLabs\VantomasWebsite\SecretSanta\Donee\Resolver::class,
	'FoundDonee',
	\DreadLabs\Vantomas\Domain\EventListener\PersistSecretSantaPairListener::class,
	'handle'
);

$cdnInterceptor = \DreadLabs\Vantomas\Hook\TypoScriptFrontendControllerHook::class . '->interceptCdnReplacements';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = $cdnInterceptor;

// -- register threat detection auth service for frontend
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
	$_EXTKEY,
	'auth',
	\DreadLabs\Vantomas\Authentication\Frontend\ThreatDetection::class,
	array(
		'title' => 'Frontend login threat detection',
		'description' => 'Detects threats on the frontend login',
		'subtype' => 'authUserFE',
		'available' => TRUE,
		// must be higher than \TYPO3\CMS\Sv\AuthenticationService (50), rsaauth (60) and saltedpasswords (70)
		'priority' => 90,
		'quality' => 50,
		'os' => '',
		'exec' => '',
		'className' => \DreadLabs\Vantomas\Authentication\Frontend\ThreatDetection::class,
	)
);
