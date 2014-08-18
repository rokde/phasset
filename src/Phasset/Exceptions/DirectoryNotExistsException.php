<?php namespace Rokde\Phasset\Exceptions;

use Exception;
use InvalidArgumentException;

/**
 * Class DirectoryNotExistsException
 *
 * Directory does not exists
 *
 * @package Rokde\Phasset\Repositories\Exceptions
 */
class DirectoryNotExistsException extends InvalidArgumentException
{
	/**
	 * creates a directory not exists exception
	 *
	 * @param string $path
	 * @param Exception|null $previous
	 */
	public function __construct($path, Exception $previous = null)
	{
		parent::__construct('Directory ' . $path . ' does not exists', 0, $previous);
	}
}