<?php namespace Rokde\Phasset\Assets;

/**
 * Interface Writable
 *
 * For all writable files
 *
 * @package Rokde\Phasset\Assets
 */
interface Writable
{
	/**
	 * writes a file
	 *
	 * @return void
	 */
	public function write();
}