<?php namespace Rokde\Phasset\Repositories;

use ReflectionClass;
use Rokde\Phasset\Exceptions\FilterUnknownException;
use Rokde\Phasset\Filters\Filterable;

class FilterRepository
{
	/**
	 * filter registry
	 * - key is an identifier
	 * - value is a class definition or resolved class instance
	 *
	 * @var array|Filterable[]
	 */
	private $filters = array();

	/**
	 * sets filter, overwrites all existing ones
	 *
	 * @param array|Filterable[] $filters
	 * @return FilterRepository
	 */
	public function setFilter(array $filters)
	{
		$this->filters = $filters;

		return $this;
	}

	/**
	 * @param string $key
	 * @return Filterable
	 * @throws \InvalidArgumentException
	 */
	public function getFilter($key)
	{
		if (! array_key_exists($key, $this->filters))
			throw new \InvalidArgumentException('Filter ' . $key . ' is unknown');

		$filter = $this->filters[$key];
		if (is_object($filter))
		{
			return $filter;
		}

		if (is_string($filter))
			$this->filters[$key] = $this->resolveFilter($filter);
		else
			$this->filters[$key] = $this->resolveFilter($filter['class'], $filter['options']);

		return $this->filters[$key];
	}

	/**
	 * resolves a filter by name
	 *
	 * @param string $filter
	 * @param array $params
	 * @throws \Rokde\Phasset\Exceptions\FilterUnknownException
	 * @return Filterable
	 */
	private function resolveFilter($filter, array $params = [])
	{
		$class = new ReflectionClass($filter);
		if (!$class->isInstantiable())
			throw new FilterUnknownException($filter);

		if (empty($params))
			return $class->newInstance();

		return $class->newInstanceArgs($params);
	}
}