<?php namespace Rokde\Phasset\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 *
 * The update command updates all target files by processing the source files.
 *
 * @package Rokde\Phasset\Commands
 */
class UpdateCommand extends Command
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
		$output->writeln('Update running');
	}
}