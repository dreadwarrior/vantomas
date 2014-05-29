<?php
namespace DreadLabs\SecretSanta\Domain\Repository;

/***************************************************************
 * Copyright notice
 *
 * (c) 2014 Thomas Juhnke <typo3@van-tomas.de>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * The Pair repository
 *
 * @package \DreadLabs\SecretSanta\Domain\Repository
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class PairRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Amount of maximum mutual loops
	 *
	 * @var integer
	 */
	const MAX_MUTUAL_LOOP = 1000;

	/**
	 * Try to find a pair for the given $frontendUser
	 *
	 * @param FrontendUser $frontendUser
	 * @return NULL|\DreadLabs\SecretSanta\Domain\Model\Pair
	 */
	public function findPairFor(FrontendUser $frontendUser) {
		$query = $this->createQuery();

		$query->matching(
			$query->equals('leftParticipant', $frontendUser)
		);

		return $query->execute()->getFirst();
	}

	/**
	 * Tries to find a participant uid for $frontendUser
	 *
	 * @param FrontendUser $frontendUser
	 * @param integer $storagePid
	 * @return integer
	 */
	public function findParticipantUidFor(FrontendUser $frontendUser, $storagePid) {
		$possibleParticipant = $this->findPossibleParticipantFor(
			$frontendUser,
			$storagePid
		);

		$i = 0;

		while (
			$this->areParticipantsMutually(
				$frontendUser,
				$possibleParticipant['uid']
			)
			&& $i < self::MAX_MUTUAL_LOOP
		) {
			$possibleParticipant = $this->findPossibleParticipantFor(
				$frontendUser,
				$storagePid
			);

			$i++;
		}

		// if no possible pairing could be determined
		if (
			!isset($possibleParticipant['uid'])
			|| 0 === (integer) $possibleParticipant['uid']
		) {
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'uid, username',
				'fe_users',
				'pid = ' . $storagePid . ' AND uid != ' . $frontendUser->getUid(),
				'',
				'RAND()',
				'1'
			);
			$possibleParticipant = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		}

		$this->savePair(
			$frontendUser,
			$possibleParticipant['uid'], $storagePid
		);

		return $possibleParticipant['uid'];
	}

	/**
	 *
	 * @param FrontendUser $frontendUser
	 * @param integer $storagePid
	 */
	protected function findPossibleParticipantFor(
		FrontendUser $frontendUser,
		$storagePid
	) {
		$query = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'u.uid, u.username',
			'fe_users u LEFT JOIN tx_secretsanta_domain_model_pair p ON u.uid = p.right_participant',
			'p.right_participant IS NULL AND u.pid = '. $storagePid .' AND u.uid != '. $frontendUser->getUid(),
			'',
			'RAND()',
			'1'
		);

		return $GLOBALS['TYPO3_DB']->sql_fetch_assoc($query);
	}

	/**
	 * Checks if the participants are mutually
	 *
	 * @param FrontendUser $frontendUser
	 * @param integer $possibleParticipantUid
	 * @return boolean
	 */
	protected function areParticipantsMutually(
		FrontendUser $frontendUser,
		$possibleParticipantUid
	) {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows(
			'*',
			'tx_secretsanta_domain_model_pair',
			'left_user = ' . $possibleParticipantUid . ' AND right_user = ' . $frontendUser->getUid()
		);

		return (bool) $res;
	}

	/**
	 * Saves the pairing
	 *
	 * @param FrontendUser$frontendUser
	 * @param integer $possibleParticipantUid
	 * @param integer $storagePid
	 * @return mixed
	 */
	protected function savePair(
		FrontendUser $frontendUser,
		$possibleParticipantUid,
		$storagePid
	) {
		$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery(
			'tx_secretsanta_domain_model_pair',
			array(
				'pid' => $storagePid,
				'left_participant' => $frontendUser->getUid(),
				'right_participant' => $possibleParticipantUid
			)
		);

		return $res;
	}
}