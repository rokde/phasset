<?php
/**
 * phasset
 *
 * @author rok
 * @since 19.08.14
 */

namespace Rokde\Phasset\Events;


use Rokde\Phasset\Assets\TargetFile;
use Symfony\Component\EventDispatcher\Event;

class TargetFileEvent extends Event {

	/**
	 *
	 *
	 * @var \Rokde\Phasset\Assets\TargetFile
	 */
	private $targetFile;
	/**
	 *
	 *
	 * @var
	 */
	private $countTargetFiles;
	/**
	 *
	 *
	 * @var
	 */
	private $step;

	/**
	 * @param TargetFile $targetFile
	 * @param int $countTargetFiles
	 * @param int $step
	 */
	public function __construct(TargetFile $targetFile, $countTargetFiles, $step)
	{
		$this->targetFile = $targetFile;
		$this->countTargetFiles = $countTargetFiles;
		$this->step = $step;
	}

	/**
	 * @return mixed
	 */
	public function getCountTargetFiles()
	{
		return $this->countTargetFiles;
	}

	/**
	 * @return \Rokde\Phasset\Assets\TargetFile
	 */
	public function getTargetFile()
	{
		return $this->targetFile;
	}
}