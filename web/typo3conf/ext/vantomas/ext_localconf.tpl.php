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
$composerAutoloader->addPsr4('Symfony\\Component\\Filesystem\\', PATH_site . '/../vendor/symfony/filesystem/');
$composerAutoloader->addPsr4('Symfony\\Component\\Config\\', PATH_site . '/../vendor/symfony/config/');
$composerAutoloader->addPsr4('Symfony\\Component\\Console\\', PATH_site . '/../vendor/symfony/console/');
$composerAutoloader->addPsr4('Symfony\\Component\\Yaml\\', PATH_site . '/../vendor/symfony/yaml');
$composerAutoloader->addPsr4('Phinx\\', PATH_site . '/../vendor/robmorgan/phinx/src/Phinx/');
$composerAutoloader->add('NinjaMutex', PATH_site . '/../vendor/arvenil/ninja-mutex/src/');

// register autoloading
$composerAutoloader->register(TRUE);

// override core database connection class
if (!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('dbal')) {
	/* @var $extbaseObjectContainer \TYPO3\CMS\Extbase\Object\Container\Container */
	$extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
		\TYPO3\CMS\Extbase\Object\Container\Container::class
	);

	$extbaseObjectContainer->registerImplementation(
		\DreadLabs\VantomasWebsite\Migration\MediatorInterface::class,
		\DreadLabs\VantomasWebsite\Migration\Mediator\PhinxLocking::class
	);
	$extbaseObjectContainer->registerImplementation(
		\DreadLabs\VantomasWebsite\Migration\MigratorInterface::class,
		\DreadLabs\VantomasWebsite\Migration\Migrator\Phinx::class
	);
	$extbaseObjectContainer->registerImplementation(
		\Phinx\Config\ConfigInterface::class,
		\DreadLabs\Vantomas\Domain\Migration\Configuration\Typo3CmsConfiguration::class
	);
	$extbaseObjectContainer->registerImplementation(
		\NinjaMutex\Lock\LockInterface::class,
		\DreadLabs\Vantomas\Domain\Migration\Locking\Typo3TempFlockLock::class
	);
	$extbaseObjectContainer->registerImplementation(
		\DreadLabs\VantomasWebsite\Migration\LoggerInterface::class,
		\DreadLabs\Vantomas\Domain\Migration\Logger::class
	);
	$extbaseObjectContainer->registerImplementation(
		\DreadLabs\VantomasWebsite\Migration\OutputInterface::class,
		\DreadLabs\Vantomas\Domain\Migration\NullOutput::class
	);

	$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Database\DatabaseConnection::class] = array(
		'className' => \DreadLabs\Vantomas\Database\DatabaseConnection::class
	);
}

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

// -- logging for migrations
$GLOBALS['TYPO3_CONF_VARS']['LOG']['DreadLabs']['Vantomas']['Domain']['Migration']['writerConfiguration'] = array(
	\TYPO3\CMS\Core\Log\LogLevel::${TYPO3_CONF_VARS.LOG.DreadLabs.Vantomas.Domain.Migration.writerConfiguration.LogLevel} => array(
		\TYPO3\CMS\Core\Log\Writer\${TYPO3_CONF_VARS.LOG.DreadLabs.Vantomas.Domain.Migration.writerConfiguration.LogLevel.Writer}::class => array(
			'logFile' => 'typo3temp/logs/migration.log',
		),
	),
);
