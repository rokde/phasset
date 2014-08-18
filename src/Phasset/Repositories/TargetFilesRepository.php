<?php namespace Rokde\Phasset\Repositories;


use Rokde\Phasset\Assets\TargetFile;
use Rokde\Phasset\Events\TargetFileCountEvent;
use Rokde\Phasset\Events\TargetFileEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TargetFilesRepository
{
	/**
	 * source files
	 *
	 * @var SourceFilesRepository
	 */
	private $sourceFilesRepository;

	/**
	 * base path
	 *
	 * @var string
	 */
	private $basePath;

	/**
	 * target files
	 *
	 * @var array|TargetFile[]
	 */
	private $targets = array();

	/**
	 * events dispatcher
	 *
	 * @var \Illuminate\Events\Dispatcher
	 */
	private $events;

	/**
	 * @param SourceFilesRepository $sourceFilesRepository
	 * @param string $basePath
	 * @param EventDispatcherInterface $events
	 */
	public function __construct(SourceFilesRepository $sourceFilesRepository, $basePath, EventDispatcherInterface $events)
	{
		$this->sourceFilesRepository = $sourceFilesRepository;
		$this->basePath = $basePath;

		$this->events = $events;
	}

	/**
	 * sets a list of target files consisting source files each
	 *
	 * @param array $targets
	 * @return self
	 */
	public function setTargets(array $targets)
	{
		foreach ($targets as $target => $sourceFiles)
		{
			$this->addTarget($target, $sourceFiles);
		}

		return $this;
	}

	/**
	 * adds a target file with source files
	 *
	 * @param string $target
	 * @param array $sourceFiles
	 * @return self
	 */
	public function addTarget($target, $sourceFiles)
	{
		if (! $target instanceof TargetFile)
		{
			$target = new TargetFile($target, $this->events);
		}
		$target->setBasePath($this->basePath);
		foreach ($sourceFiles as $sourceFile)
		{
			$source = $this->sourceFilesRepository->getOrCreate($sourceFile);
			$target->addSourceFile($source);
		}

		$this->targets[$target->getFilename()] = $target;

		return $this;
	}

	/**
	 * updates all targets containing source file
	 *
	 * @param string $file
	 */
	public function updateTargetsWithSourceFile($file)
	{
		$targetFileCount = count($this->targets);

		foreach ($this->targets as $target)
		{
			if ($target->hasSourceFile($file))
			{
				$this->writeTarget($target, $targetFileCount);
			}
		}
	}

	/**
	 * updates all configured targets
	 */
	public function update()
	{
		$targetFileCount = count($this->targets);

		$event = new TargetFileCountEvent($targetFileCount);
		$this->fire('phasset.target.updating', $event);

		$step = 0;
		foreach ($this->targets as $target)
		{
			$this->writeTarget($target, $targetFileCount, ++$step);
		}

		$this->fire('phasset.target.updated', $event);
	}

	/**
	 * fires an event
	 *
	 * @param string $event
	 * @param Event $payload
	 */
	private function fire($event, $payload)
	{
		if ($this->events === null)
			return;

		$this->events->dispatch($event, $payload);
	}

	/**
	 * writes target with events fired
	 *
	 * @param TargetFile $target
	 * @param int $targetFileCount
	 * @param int $step
	 */
	protected function writeTarget($target, $targetFileCount, $step = 0)
	{
		$event = new TargetFileEvent($target, $targetFileCount, $step);
		$this->fire('phasset.target.writing', $event);

		$target->write();

		$this->fire('phasset.target.written', $event);
	}
}