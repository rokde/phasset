<?php namespace Rokde\Phasset\Assets;

use Rokde\Phasset\Exceptions\DirectoryNotExistsException;
use Rokde\Phasset\Utilities\String;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class File
 *
 * Abstract file implementation and asset file representation
 *
 * @package Rokde\Phasset\Assets
 */
abstract class File
{
	/**
	 * absolute path to file
	 *
	 * @var string
	 */
	protected $basePath = '';

	/**
	 * filename
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * events dispatcher
	 *
	 * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
	 */
	private $events;

	/**
	 * create with optional events dispatcher
	 *
	 * @param string $filename
	 * @param EventDispatcherInterface $events
	 */
	public function __construct($filename, EventDispatcherInterface $events = null)
	{
		$this->filename = $filename;
		$this->events = $events;
	}

	/**
	 * returns the absolute filename
	 *
	 * @return string
	 */
	public function getFilename()
	{
		return $this->basePath . $this->filename;
	}

	/**
	 * does the file exists
	 *
	 * @return bool
	 */
	public function exists()
	{
		return file_exists($this->getFilename());
	}

	/**
	 * returns true, when file equals current file
	 *
	 * @param string|File $file
	 * @return bool
	 */
	public function equals($file)
	{
		if ($file instanceof File)
		{
			return $this->getFilename() === $file->getFilename();
		}

		return $this->filename === $file || $this->getFilename() === $file;
	}

	/**
	 * sets base path
	 *
	 * @param string $basePath
	 * @throws DirectoryNotExistsException
	 */
	public function setBasePath($basePath)
	{
		$basePath = String::finish($basePath, DIRECTORY_SEPARATOR);
		if (!file_exists($basePath))
			throw new DirectoryNotExistsException($basePath);

		$this->basePath = $basePath;
	}

	/**
	 * fire an event to be dispatched for all listeners
	 *
	 * @param string $event
	 * @param array $payload
	 */
	protected function fire($event, array $payload = array())
	{
		if ($this->events === null)
			return;

		$this->events->dispatch($event, new GenericEvent($event, $payload));
	}
}