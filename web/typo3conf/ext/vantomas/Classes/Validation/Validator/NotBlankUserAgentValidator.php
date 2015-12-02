<?php
namespace DreadLabs\Vantomas\Validation\Validator;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Error;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validates if the UserAgent of the current request is not empty
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class NotBlankUserAgentValidator extends AbstractValidator
{

    /**
     * Check if $value is valid. If it is not valid, needs to add an error
     * to result.
     *
     * @param mixed $value The incoming value
     *
     * @return void
     */
    protected function isValid($value)
    {
        $value = GeneralUtility::getIndpEnv('HTTP_USER_AGENT');

        if (empty($value)) {
            $error = new Error(
                'The user agent was empty.',
                1400451338
            );
            $this->result->addError($error);
        }
    }
}
