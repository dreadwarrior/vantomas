<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
*   free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Commenting system additional marker handling
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 * @package Vantomas
 * @subpackage Hooks
 */
class Tx_Vantomas_Hooks_Comments_Marker {

	/**
	 * hook for tx_comments_pi1::comments_getComments() method additional marker handling hook
	 *
	 * @param array $params array of parameters [pObj=>&tx_comments_pi1, template=>string;content of ###SINGLE_COMMENT### subpart, markers=>array; current parsed/substituted marker array, row=>array; comment DB record]
	 * @param tx_comments_pi1 $pObj object instance tx_comments_pi1 plugin class
	 * @return array a modified array with markers
	 */
	public function comments_getComments(&$params, &$pObj) {
		$markerArray = $params['markers'];
		$markerArray['###COMMENT_UID###'] = $params['row']['uid'];

		return $markerArray;
	}
}
?>
