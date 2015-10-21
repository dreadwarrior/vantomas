<?php
namespace DreadLabs\Vantomas\Backend;

use TYPO3\CMS\Backend\View\BackendLayout\BackendLayout;

class LayoutFileInfo extends \SplFileInfo {

	/**
	 * Extension
	 *
	 * @var string
	 */
	const EXTENSION = 'txt';

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
	 * Returns the base name of the file with extension stripped
	 *
	 * @return string
	 */
	public function getIdentifier() {
		return self::IDENTIFIER_PREFIX . $this->getBasename('.' . self::EXTENSION);
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
		$fileHandle = $this->openFile('r');
		$content = $fileHandle->fread($this->getSize());
		// @see https://php.net/manual/en/class.splfileobject.php#113149
		$fileHandle = NULL;

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
