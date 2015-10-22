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

/**
 * LayoutFileInfo
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class LayoutFileInfo extends \SplFileInfo {

	/**
	 * Extension
	 *
	 * @var string
	 */
	const EXTENSION = 'txt';

	/**
	 * Title prefix
	 *
	 * @var string
	 */
	const TITLE_PREFIX = 'EXT:vantomas - ';

	/**
	 * Returns the base name of the file with extension stripped
	 *
	 * @return string
	 */
	public function getIdentifier() {
		return $this->getBasename('.' . self::EXTENSION);
	}

	/**
	 * GetTitle
	 *
	 * @return string
	 */
	public function getTitle() {
		return self::TITLE_PREFIX . $this->getBasename('.' . self::EXTENSION);
	}

	/**
	 * Gets the content of the layout file
	 *
	 * @return string
	 */
	public function getContent() {
		if (method_exists('SplFileObject', 'fread')) {
			$content = $this->getContentFromSplFileObject();
		} else {
			$content = $this->getContentFromFilesystemFunctions();
		}

		return $content;
	}

	/**
	 * GetContentFromSplFileObject
	 *
	 * @TODO: make this the default if upgrading to PHP 5.5.11+
	 *
	 * @return string
	 */
	private function getContentFromSplFileObject() {
		$fileHandle = $this->openFile('r');
		$content = $fileHandle->fread($this->getSize());
		// @see https://php.net/manual/en/class.splfileobject.php#113149
		$fileHandle = NULL;

		return $content;
	}

	/**
	 * GetContentFromFilesystemFunctions
	 *
	 * @return string
	 */
	private function getContentFromFilesystemFunctions() {
		$fileHandle = fopen($this->getRealPath(), 'r');
		$content = fread($fileHandle, $this->getSize());
		fclose($fileHandle);

		return $content;
	}

	/**
	 * Transforms this object into a BackendLayout object
	 *
	 * @return BackendLayout
	 */
	public function toBackendLayout() {
		return BackendLayout::create($this->getIdentifier(), $this->getTitle(), $this->getContent());
	}
}
