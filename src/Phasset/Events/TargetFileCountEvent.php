<?php
/**
 * phasset
 *
 * @author rok
 * @since 19.08.14
 */

namespace Rokde\Phasset\Events;


use Symfony\Component\EventDispatcher\Event;

class TargetFileCountEvent extends Event {

	private $countTargetFiles;

	public function __construct($countTargetFiles)
	{
		$this->countTargetFiles = $countTargetFiles;
	}

	/**
	 * @return mixed
	 */
	public function getCountTargetFiles()
	{
		return $this->countTargetFiles;
	}
}