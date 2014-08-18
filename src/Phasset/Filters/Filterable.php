<?php namespace Rokde\Phasset\Filters;

/**
 * Interface Filterable
 *
 * For all filters
 *
 * @package Rokde\Phasset\Filters
 */
interface Filterable
{
	/**
	 * filters given string
	 *
	 * @param string $string
	 * @return string
	 */
	public function filter($string);

	/**
	 * is it filterable
	 *
	 * @param string $file
	 * @return bool
	 */
	public function isFilterable($file);
}