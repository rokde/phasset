<?php namespace Rokde\Phasset\Filters\Js;

use JSMin;
use Rokde\Phasset\Filters\Filterable;
use Rokde\Phasset\Utilities\String;

/**
 * Class MinifyFilter
 *
 * Javascript minifier
 *
 * @package Rokde\Phasset\Filters\Js
 */
class MinifyFilter implements Filterable
{
	/**
	 * filters given string
	 *
	 * @param string $string
	 * @return string
	 */
	public function filter($string)
	{
		return JSMin::minify($string);
	}

	/**
	 * is given file filterable
	 *
	 * @param string $file
	 * @return bool
	 */
	public function isFilterable($file)
	{
		return ! String::endsWith($file, '.min.js') && String::endsWith($file, '.js');
	}
}