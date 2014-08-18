<?php namespace Rokde\Phasset\Assets;

use Rokde\Phasset\Filters\Filterable;

/**
 * Class SourceFile
 *
 * This represents a source file for the asset manager.
 *
 * @package Rokde\Phasset\Assets
 */
class SourceFile extends File implements Readable
{
	/**
	 * all filters set
	 *
	 * @var array|Filterable[]
	 */
	private $filters = array();

	/**
	 * adds a filter
	 *
	 * @param Filterable $filter
	 * @return $this
	 */
	public function addFilter(Filterable $filter)
	{
		$this->filters[] = $filter;

		return $this;
	}

	/**
	 * reads the source file
	 *
	 * @return string
	 */
	public function read()
	{
		if (! $this->exists())
			return '';

		$content = file_get_contents($this->getFilename());

		foreach ($this->filters as $filter)
		{
			if (! $filter->isFilterable($this->getFilename()))
				continue;

			$content = $filter->filter($content);
		}

		return $content;
	}
}