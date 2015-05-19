<?php
namespace DreadLabs\Vantomas\Authentication;

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

/**
 * ControlInterface
 *
 * What is a control?
 *
 * "Controls are defensive technologies or modules that are used to detect,
 * deter, or deny attacks."
 *
 * @see https://www.owasp.org/index.php/Category:Control
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
interface ControlInterface {

	/**
	 * Flags if the used Control impl detected a threat
	 *
	 * @return bool
	 */
	public function isThreat();
}
