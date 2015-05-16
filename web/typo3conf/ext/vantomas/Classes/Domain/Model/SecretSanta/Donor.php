<?php
namespace DreadLabs\Vantomas\Domain\Model\SecretSanta;

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

use DreadLabs\VantomasWebsite\SecretSanta\Donor\DonorInterface;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

/**
 * Donor
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Donor extends FrontendUser implements DonorInterface {
}
