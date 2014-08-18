<?php namespace Rokde\Phasset\Commands;

use Rokde\Phasset\Observers\BasicStatusNotifier;
use Rokde\Phasset\Observers\SourceFileProcessingNotifier;
use Rokde\Phasset\Observers\TargetFileWrittenNotifier;
use Rokde\Phasset\Repositories\FilterRepository;
use Rokde\Phasset\Repositories\SourceFilesRepository;
use Rokde\Phasset\Repositories\TargetFilesRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class UpdateCommand
 *
 * The update command updates all target files by processing the source files.
 *
 * @package Rokde\Phasset\Commands
 */
class UpdateCommand extends BaseCommand
{
	/**
	 * configures current command
	 */
	protected function configure()
	{
		$this->setName('update')
			->setDescription('Updates all specified target files');
	}

	/**
	 * executes current command
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$config = $this->getConfig();

		$output->writeln('as');

		$filterRepository = new FilterRepository();
		$filterRepository->setFilter($config['filters']);

		$sourceFilesRepository = new SourceFilesRepository($filterRepository, getcwd());
		$sourceFilesRepository->setSources($config['sources']);

		$events = new EventDispatcher();

		if (in_array($output->getVerbosity(), array(OutputInterface::VERBOSITY_NORMAL, OutputInterface::VERBOSITY_VERBOSE, OutputInterface::VERBOSITY_VERY_VERBOSE)))
			$basicNotifier = new BasicStatusNotifier($this, $events);

		if ($output->getVerbosity() === OutputInterface::VERBOSITY_VERBOSE)
			$targetFileWrittenNotifier = new TargetFileWrittenNotifier($this, $events);

		if ($output->getVerbosity() === OutputInterface::VERBOSITY_VERY_VERBOSE)
			$sourceFileProcessingNotifier = new SourceFileProcessingNotifier($this, $events);


		$targetFilesRepository = new TargetFilesRepository($sourceFilesRepository, getcwd(), $events);
		$targetFilesRepository->setTargets($config['targets']);

		$targetFilesRepository->update();
	}

	private function getConfig()
	{
		/** @TODO replace current settings with dynamic replacement by configuration file */

		$basePath = __DIR__.'/../../../../mitarbeiterbereich2/';

		return [
			/**
			 * which folder should be watched
			 */
			'watchFolder' => [
				/**
				 * concrete existing folder
				 * - with optional filter
				 */
				$basePath . 'app/assets' => [
					'*.css',
					'*.js',
				],
			],

			/**
			 * how to proceed the assets
			 */
			'sources' => [
				/**
				 * concrete asset
				 * - with the necessary processing filters
				 */
				$basePath . 'app/assets/stylesheets/application.css' => [
					'minify-css'
				],
				$basePath . 'app/assets/javascripts/application.js' => [
					'minify-js'
				],
			],

			/**
			 * where to store which assets
			 */
			'targets' => [
				/**
				 * concrete target asset: will be written and updated on source changes
				 */
				'public/assets/application.css' => [
					$basePath . 'app/assets/stylesheets/application.css',
				],
				'public/assets/application.js' => [
					$basePath . 'app/assets/javascripts/application.js'
				],
			],

			/**
			 * filter definition
			 * id => fully qualified class name
			 * or
			 * id => [class => full qualified class name, options => options for constructor]
			 *
			 * id will be used in sources array for each configured file
			 */
			'filters' => [
				'minify-css' => 'Rokde\Phasset\Filters\Css\MinifyFilter',
				'minify-js' => 'Rokde\Phasset\Filters\Js\MinifyFilter',
				'less' => 'Rokde\Phasset\Filters\Less\LessCompiler',
				'sass' => 'Rokde\Phasset\Filters\Sass\ScssCompiler',
			],
		];
	}
}