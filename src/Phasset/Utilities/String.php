<?php namespace Rokde\Phasset\Utilities;

/**
 * Class String
 *
 * String utility functions
 *
 * @package Rokde\Phasset\Utilities
 */
class String
{
	/**
	 * finishes a string with given cap
	 *
	 * @param string $value
	 * @param string $cap
	 * @return string
	 */
	public static function finish($value, $cap)
	{
		return rtrim($value, $cap) . $cap;
	}

	/**
	 * does a string ends with some of given parts
	 *
	 * @param string $haystack
	 * @param string|array $needles
	 * @return bool
	 */
	public static function endsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ($needle == substr($haystack, strlen($haystack) - strlen($needle)))
				return true;
		}

		return false;
	}
}