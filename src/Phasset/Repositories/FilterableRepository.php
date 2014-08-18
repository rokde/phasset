<?php namespace Rokde\Phasset\Repositories;

interface FilterableRepository
{
	/**
	 * adds a path with optional filters
	 *
	 * @param string $path
	 * @param array $filters
	 * @return $this
	 */
	public function setFilter($path, array $filters = array());
}