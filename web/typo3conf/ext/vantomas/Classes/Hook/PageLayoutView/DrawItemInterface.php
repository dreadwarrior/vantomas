<?php
namespace DreadLabs\Vantomas\Hook\PageLayoutView;

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

use TYPO3\CMS\Backend\View\PageLayoutView;

/**
 * DrawItemInterface
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface DrawItemInterface {

	/**
	 * Self-registers the DrawItem hook
	 *
	 * @param string $extensionKey Extension key
	 *
	 * @return void
	 */
	public static function register($extensionKey);

	/**
	 * Flags if the incoming row can be rendered by the DrawItem
	 *
	 * @param array $row The incoming tt_content row to analyze
	 *
	 * @return bool
	 */
	public function canRender(array $row);

	/**
	 * Initializes the DrawItem.
	 *
	 * You can override this in the concrete DrawItem implementation, but
	 * you should call the parent method in order to initialize some useful
	 * objects (e.g. ObjectManager).
	 *
	 * @return void
	 */
	public function initialize();

	/**
	 * Renders the header preview of a content element.
	 *
	 * The initial header content is passed as a reference like in the core's
	 * PageLayoutViewDrawItemHookInterface. The implementation has to modify
	 * the content.
	 *
	 * @param PageLayoutView $parentObject Calling parent object
	 * @param string $headerContent Header content
	 * @param array $row Record row of tt_content
	 *
	 * @return void
	 */
	public function renderHeader(PageLayoutView &$parentObject, &$headerContent, array &$row);

	/**
	 * Renders the content preview of a content element.
	 *
	 * The initial item content is passed as a reference like in the core's
	 * PageLayoutViewDrawItemHookInterface. The implementation has to modify
	 * the content.
	 *
	 * @param PageLayoutView $parentObject Calling parent object
	 * @param string $itemContent Item content
	 * @param array $row Record row of tt_content
	 *
	 * @return void
	 */
	public function renderContent(PageLayoutView &$parentObject, &$itemContent, array &$row);
}
