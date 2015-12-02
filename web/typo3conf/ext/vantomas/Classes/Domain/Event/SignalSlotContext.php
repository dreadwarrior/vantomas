<?php
namespace DreadLabs\Vantomas\Domain\Event;

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

use DreadLabs\VantomasWebsite\Event\ContextInterface;
use DreadLabs\VantomasWebsite\Event\EventInterface;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * SignalSlotContext
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SignalSlotContext implements ContextInterface
{

    /**
     * TYPO3.CMS SignalSlot Dispatcher
     *
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * TYPO3.CMS SignalSlot Dispather signal class name
     *
     * @var string
     */
    private $signalClassName;

    /**
     * Constructor
     *
     * @param Dispatcher $dispatcher TYPO3.CMS SignalSlot Dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Sets the context namespace
     *
     * @param string $namespace Signal class name in TYPO3.CMS SignalSlot Dispatcher
     *
     * @return void
     */
    public function setNamespace($namespace)
    {
        $this->signalClassName = (string) $namespace;
    }

    /**
     * Dispatches the given event
     *
     * @param EventInterface $event Event to dispatch
     *
     * @return mixed|array Event arguments will be returned on exception
     */
    public function dispatch(EventInterface $event)
    {
        try {
            return $this->dispatcher->dispatch($this->signalClassName, $event->getLabel(), $event->getArguments());
        } catch (InvalidSlotException $exc) {
            return $event->getArguments();
        } catch (InvalidSlotReturnException $exc) {
            return $event->getArguments();
        }
    }
}
