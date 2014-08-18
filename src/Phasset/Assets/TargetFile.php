<?php namespace Rokde\Phasset\Assets;

/**
 * Class TargetFile
 *
 * This represents the target file for the asset manager.
 *
 * @package Rokde\Phasset\Assets
 */
class TargetFile extends File implements Writable
{
	/**
	 * source files for given target file
	 *
	 * @var array|SourceFile[]
	 */
	private $sourceFiles = array();

	/**
	 * compression is on
	 *
	 * @var bool
	 */
	private $compression = true;

	/**
	 * compression level
	 *
	 * @var int
	 */
	private $compressionLevel = 9;

	/**
	 * add a source file to this target
	 *
	 * @param SourceFile $sourceFile
	 * @return $this
	 */
	public function addSourceFile(SourceFile $sourceFile)
	{
		$this->sourceFiles[] = $sourceFile;

		return $this;
	}

	/**
	 * writes the target file
	 */
	public function write()
	{
		$countSourceFiles = count($this->sourceFiles);
		$this->fire('source.processing', [$countSourceFiles]);

		if ($countSourceFiles <= 0)
		{
			$this->fire('source.processed', [$countSourceFiles]);
			return;
		}

		$content = array();
		$step = 0;
		foreach ($this->sourceFiles as $sourceFile)
		{
			$this->fire('source.processing.file', [$sourceFile->getFilename(), ++$step, $countSourceFiles]);

			$content[] = $sourceFile->read();
		}

		$this->fire('source.processed', [$countSourceFiles]);

		if (! is_dir(dirname($this->getFilename())))
			mkdir(dirname($this->getFilename()), 0777, true);

		file_put_contents($this->getFilename(), $content);

		if ($this->compression)
		{
			file_put_contents($this->getFilename() . '.gz',
				gzencode(implode('', $content),
					$this->compressionLevel)
			);
		}
	}

	/**
	 * has this target a defined source file
	 *
	 * @param string|File $filename
	 * @return bool
	 */
	public function hasSourceFile($filename)
	{
		foreach ($this->sourceFiles as $sourceFile)
		{
			if ($sourceFile->equals($filename))
				return true;
		}

		return false;
	}

	/**
	 * sets compression
	 *
	 * @param bool $flag
	 * @param int|null $level
	 * @return $this
	 */
	public function setCompression($flag, $level = null)
	{
		$this->compression = $flag === true;
		if ($level !== null)
		{
			$this->compressionLevel = ($level >= 0 && $level <= 9)
				? $level
				: $this->compressionLevel;
		}

		return $this;
	}

	/**
	 * has target compression
	 *
	 * @return bool
	 */
	public function hasCompression()
	{
		return $this->compression;
	}
}