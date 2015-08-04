<?php
defined('TYPO3_MODE') or die();

// -- adjust autoloading

/* @var $composerAutoloader \Composer\Autoload\ClassLoader */
$composerAutoloader = new \Composer\Autoload\ClassLoader();

// add only things we actually need during runtime
$composerAutoloader->add('Net_', PATH_site . '/../vendor/net/http/src/');
$composerAutoloader->add('Illuminate\\Support', PATH_site . '/../vendor/illuminate/support/');
$composerAutoloader->add('Arg\\Tagcloud', PATH_site . '/../vendor/arg/tagcloud/src/');
$composerAutoloader->addPsr4('DreadLabs\\VantomasWebsite\\', PATH_site . '/../vendor/dreadlabs/vantomas-website/src/');

// register autoloading
$composerAutoloader->register(TRUE);

\FluidTYPO3\Flux\Core::registerProviderExtensionKey(
	'DreadLabs.Vantomas',
	'Page'
);
\FluidTYPO3\Flux\Core::registerProviderExtensionKey(
	'DreadLabs.Vantomas',
	'Content'
);

// -- archive plugins

// -- 1. archive list

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveList',
	array(
		'Archive\List' => 'show'
	),
	array()
);

// -- 2. archive search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ArchiveSearch',
	array(
		'Archive\Search' => 'show'
	),
	array(
	)
);

// -- page statistics plugins

// -- 1. last updated pages

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'PageStatisticsLastUpdated',
	array(
		'PageStatistics' => 'lastUpdated'
	),
	array()
);

// -- comment plugins

// -- 1. latest disqus comments

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'DisqusLatest',
	array(
		'Disqus' => 'latest'
	),
	array()
);

// -- twitter plugins

// -- 1. timeline tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterTimeline',
	array(
		'Twitter' => 'timeline'
	),
	array()
);

// -- 2. search tweets

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TwitterSearch',
	array(
		'Twitter' => 'search'
	),
	array()
);

// -- tag cloud/search plugins

// -- 1. tag cloud

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagCloud',
	array(
		'Tag' => 'cloud'
	),
	array()
);

// -- 2. tag search

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'TagSearch',
	array(
		'Tag' => 'search'
	),
	array()
);

// -- contact form

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'ContactForm',
	array(
		'Form\Contact' => 'new, send, success',
	),
	array(
		'Form\Contact' => 'new, send, success',
	)
);

// -- RSS feed

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'RssFeed',
	array(
		'Rss' => 'feed'
	),
	array(
	)
);

// -- sitemap.xml

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'SitemapXml',
	array(
		'Sitemap' => 'xml'
	),
	array()
);

// -- secret santa

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DreadLabs.' . $_EXTKEY,
	'SecretSanta',
	array(
		'SecretSanta' => 'loginForm,login,show,logout'
	),
	array(
		'SecretSanta' => 'loginForm,login,show,logout'
	)
);

/* @var $signalSlotDispatcher \TYPO3\CMS\Extbase\SignalSlot\Dispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility
	::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

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

$cdnInterceptorPath = 'EXT:vantomas/Classes/Hook/TypoScriptFrontendControllerHook.php';
$cdnInterceptorCallable = 'DreadLabs\\Vantomas\\Hook\\TypoScriptFrontendControllerHook->interceptCdnReplacements';
$cdnInterceptor = $cdnInterceptorPath . ':&' . $cdnInterceptorCallable;
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
