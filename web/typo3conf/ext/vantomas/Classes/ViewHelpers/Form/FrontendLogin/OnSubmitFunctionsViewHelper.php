<?php
namespace DreadLabs\Vantomas\ViewHelpers\Form\FrontendLogin;

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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Exception\InvalidVariableException;
use TYPO3\CMS\Rsaauth\RsaEncryptionEncoder;

/**
 * OnSubmitFunctionsViewHelper
 *
 * Populates the the 'onSubmit' and 'extraHiddenFields' variables to the template
 *
 * Usage:
 *
 * {namespace vt=DreadLabs\Vantomas\ViewHelpers}
 *
 * <vt:form.frontendLogin.onSubmitFunctions>
 *   <form action="..." onsubmit="{onSubmit}">
 *     ...
 *     <f:format.html parseFuncTSPath="">{extraHiddenFields}</f:format.html>
 *   </form>
 * </vt:form.frontendLogin.onSubmitFunctions>
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class OnSubmitFunctionsViewHelper extends AbstractViewHelper {

	/**
	 * Stack of submit functions for the <form/>-tag
	 *
	 * @var array
	 */
	private $submitFunctions = array();

	/**
	 * Stack of extra hidden fields for the form
	 *
	 * @var array
	 */
	private $extraHiddenFields = array();

	/**
	 * Populates the 'onSubmit' and 'extraHiddenFields' variables to the template
	 *
	 * @return string
	 * @throws InvalidVariableException If removing the additional template
	 * variables fails
	 */
	public function render() {
		/* @var $encryptionEncoder RsaEncryptionEncoder */
		$encryptionEncoder = GeneralUtility::makeInstance(RsaEncryptionEncoder::class);
		$encryptionEncoder->enableRsaEncryption();

		$this->processHooks();

		$onSubmit = '; return true;';

		if (count($this->submitFunctions)) {
			$onSubmit = implode('; ', $this->submitFunctions) . $onSubmit;
		}

		$extraHiddenFields = '';

		if (count($this->extraHiddenFields)) {
			$extraHiddenFields = implode(chr(10), $this->extraHiddenFields);
		}

		$this->templateVariableContainer->add('onSubmit', $onSubmit);
		$this->templateVariableContainer->add('extraHiddenFields', $extraHiddenFields);

		$content = $this->renderChildren();

		$this->templateVariableContainer->remove('onSubmit');
		$this->templateVariableContainer->remove('extraHiddenFields');

		return $content;
	}

	/**
	 * Process hooks for frontend login form
	 *
	 * The processed hook stack is:
	 * TYPO3_CONF_VARS.EXTCONF.felogin.loginFormOnSubmitFuncs
	 *
	 * @return void
	 */
	private function processHooks() {
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['loginFormOnSubmitFuncs'])) {
			$hookParameters = array();
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['loginFormOnSubmitFuncs'] as $callableReference) {
				list($onSubmitFunction, $extraHiddenField) = GeneralUtility::callUserFunction(
					$callableReference,
					$hookParameters,
					$this
				);
				$this->submitFunctions[] = $onSubmitFunction;
				$this->extraHiddenFields[] = $extraHiddenField;
			}
		}
	}
}
