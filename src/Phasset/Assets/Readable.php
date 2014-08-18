<?php namespace Rokde\Phasset\Assets;

/**
 * Interface Readable
 *
 * For all readable files
 *
 * @package Rokde\Phasset\Assets
 */
interface Readable
{
	/**
	 * reads in a file
	 *
	 * @return string
	 */
	public function read();
}