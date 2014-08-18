<?php namespace Rokde\Phasset\Observers;


use Rokde\Phasset\Commands\BaseCommand;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class BaseObserver {

	/**
	 * command reference
	 *
	 * @var BaseCommand
	 */
	protected $command;

	/**
	 * event listener
	 *
	 * @var EventDispatcherInterface
	 */
	protected $events;

	/**
	 * constructs observer
	 *
	 * @param BaseCommand $command
	 * @param EventDispatcherInterface $events
	 */
	public function __construct(BaseCommand $command, EventDispatcherInterface $events)
	{
		$this->command = $command;
		$this->events = $events;
		$this->observe();
	}

	abstract public function observe();

}