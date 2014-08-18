<?php namespace Rokde\Phasset\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class AboutCommand
 *
 * The about command.
 *
 * @package Rokde\Phasset\Commands
 */
class AboutCommand extends BaseCommand
{
	/**
	 * configures the current command
	 */
	protected function configure()
	{
		$this->setName('about')
			->setDescription('About Phasset');
	}

	/**
	 * executes the current command
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln(<<<EOT
<info>Phasset - Asset Management for PHP</info>
<comment>Phasset is an asset manager for any web application.
It Provides static file generation within your development process.</comment>
EOT
		);
	}
}