<?php namespace Rokde\Phasset\Exceptions;

use Exception;
use InvalidArgumentException;

class FilterUnknownException extends InvalidArgumentException
{
	public function __construct($filter, Exception $previous = null)
	{
		parent::__construct('Filter ' . $filter . ' unknown', 0, $previous);
	}
}