<?php
/**
 * phasset
 *
 * @author rok
 * @since 19.08.14
 */

namespace Rokde\Phasset\Utilities;


class Debug {

	/**
	 * dump and die all given arguments
	 *
	 * @param mixed $arg
	 */
	public static function dump()
	{
		array_map(function($x) { var_dump($x); }, func_get_args()); die;
	}
}