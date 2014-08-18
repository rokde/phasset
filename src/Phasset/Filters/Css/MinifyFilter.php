<?php namespace Rokde\Phasset\Filters\Css;

use CSSmin;
use Rokde\Phasset\Filters\Filterable;
use Rokde\Phasset\Utilities\String;

class MinifyFilter implements Filterable
{
	/**
	 * internal use of css minifier
	 *
	 * @var CSSmin
	 */
	private $cssMinifier;

	/**
	 * instantiate css minifier filter
	 */
	public function __construct()
	{
		$this->cssMinifier = new CSSmin();
	}

	/**
	 * filters given string
	 *
	 * @param string $string
	 * @return string
	 */
	public function filter($string)
	{
		return $this->cssMinifier->run($string);
	}

	/**
	 * is given file filteable
	 *
	 * @param string $file
	 * @return bool
	 */
	public function isFilterable($file)
	{
		return ! String::endsWith($file, '.min.css') && String::endsWith($file, '.css');
	}
}