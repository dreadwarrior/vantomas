<?php
namespace DreadLabs\Vantomas\Mailer;

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

use DreadLabs\VantomasWebsite\Mailer\ConveyableInterface;
use DreadLabs\VantomasWebsite\Mailer\Exception\FailedRecipientsException;
use DreadLabs\VantomasWebsite\Mailer\MessageInterface;
use DreadLabs\VantomasWebsite\Mailer\TemplateInterface;
use DreadLabs\VantomasWebsite\MailerInterface;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;

/**
 * Mail handling
 *
 * @package \DreadLabs\Vantomas\Controller
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class Mailer implements MailerInterface {

	/**
	 *
	 * @var TemplateInterface
	 */
	protected $template;

	/**
	 *
	 * @var MessageInterface
	 */
	protected $message;

	/**
	 *
	 * @var Logger
	 */
	protected $logger;

	/**
	 *
	 * @param TemplateInterface $template
	 * @param MessageInterface $message
	 * @param LogManager $logManager
	 */
	public function __construct(
		TemplateInterface $template,
		MessageInterface $message,
		LogManager $logManager
	) {
		$this->template = $template;
		$this->message = $message;

		$this->logger = $logManager->getLogger(__CLASS__);
	}

	/**
	 *
	 * @param ConveyableInterface $conveyable
	 */
	public function send(ConveyableInterface $conveyable) {
		try {
			$conveyable->prepareMailTemplate($this->template);
			$this->template->render($this->message);
			$this->message->send();
		} catch (FailedRecipientsException $e) {
			$this->logger->alert('The mail could not been sent.',
				array(
					'sender' => $e->getSenderList(),
					'receiver' => $e->getReceiverList(),
					'failedRecipients' => $e->getFailedRecipients(),
				)
			);
		}
	}
}