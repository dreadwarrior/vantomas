<?php
namespace DreadLabs\Vantomas\Backend;

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

use TYPO3\CMS\Backend\View\BackendLayout\BackendLayout;
use TYPO3\CMS\Backend\View\BackendLayout\BackendLayoutCollection;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderContext;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderInterface;
use TYPO3\CMS\Backend\View\BackendLayoutView;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * LayoutDataProvider
 *
 * Provides all layouts shipped with ext:vantomas
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class LayoutDataProvider implements DataProviderInterface {

	/**
	 * Extension key
	 *
	 * @var string
	 */
	const EXTENSION_KEY = 'vantomas';

	/**
	 * Layout path in ext:vantomas
	 *
	 * @var string
	 */
	const LAYOUT_PATH = 'Configuration/BackendLayouts/';

	/**
	 * Identifier prefix
	 *
	 * @var string
	 */
	const IDENTIFIER_PREFIX = 'vantomas_';

	/**
	 * Title prefix
	 *
	 * @var string
	 */
	const TITLE_PREFIX = 'EXT:vantomas - ';

	/**
	 * Adds backend layouts to the given backend layout collection.
	 *
	 * @param DataProviderContext $dataProviderContext
	 * @param BackendLayoutCollection $backendLayoutCollection
	 * @return void
	 */
	public function addBackendLayouts(
		DataProviderContext $dataProviderContext,
		BackendLayoutCollection $backendLayoutCollection
	) {
		$layoutFiles = $this->getLayoutFiles();

		foreach ($layoutFiles as $fileName) {
			$backendLayoutCollection->add($this->createBackendLayout($fileName));
		}
	}

	/**
	 * GetLayoutFiles
	 *
	 * @return array|string
	 */
	private function getLayoutFiles() {
		return GeneralUtility::getFilesInDir(
			ExtensionManagementUtility::extPath(self::EXTENSION_KEY, self::LAYOUT_PATH),
			'txt'
		);
	}

	/**
	 * CreateBackendLayout
	 *
	 * @param string $fileName
	 *
	 * @return BackendLayout
	 */
	private function createBackendLayout($fileName) {
		$identifier = $this->getIdentifier($fileName);
		$title = $this->getTitle($fileName);

		$content = $this->getLayoutFileContent($fileName);

		return BackendLayout::create($identifier, $title, $content);
	}

	/**
	 * GetIdentifier
	 *
	 * @param string $fileName
	 *
	 * @return string
	 */
	private function getIdentifier($fileName) {
		return self::IDENTIFIER_PREFIX . $this->getFileNameWithoutExtension($fileName);
	}

	/**
	 * GetFileNameWithoutExtension
	 *
	 * @param string $fileName
	 *
	 * @return string
	 */
	private function getFileNameWithoutExtension($fileName) {
		return substr($fileName, 0, strrpos($fileName, '.'));
	}

	/**
	 * GetTitle
	 *
	 * @param string $fileName
	 *
	 * @return string
	 */
	private function getTitle($fileName) {
		return self::TITLE_PREFIX . $this->getFileNameWithoutExtension($fileName);
	}

	/**
	 * GetLayoutFileContent
	 *
	 * @param string $fileName
	 * @return string
	 */
	private function getLayoutFileContent($fileName) {
		return GeneralUtility::getUrl(
			ExtensionManagementUtility::extPath(
				self::EXTENSION_KEY,
				self::LAYOUT_PATH . $fileName
			)
		);
	}

	/**
	 * Gets a backend layout by (regular) identifier.
	 *
	 * @param string $identifier
	 * @param int $pageId
	 * @return NULL|BackendLayout
	 */
	public function getBackendLayout($identifier, $pageId) {
		$backendLayout = $this->getDefaultBackendLayout();

		$layoutFiles = $this->getLayoutFiles();

		foreach ($layoutFiles as $fileName) {
			if ($identifier !== $this->getIdentifier($fileName)) {
				continue;
			}

			$backendLayout = $this->createBackendLayout($fileName);
		}

		return $backendLayout;
	}

	/**
	 * GetDefaultBackendLayout
	 *
	 * @return BackendLayout
	 */
	private function getDefaultBackendLayout() {
		return BackendLayout::create(
			'default',
			'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.backend_layout.default',
			BackendLayoutView::getDefaultColumnLayout()
		);
	}
}
