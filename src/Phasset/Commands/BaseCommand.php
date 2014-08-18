<?php namespace Rokde\Phasset\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command {

	/**
	 * The input interface implementation.
	 *
	 * @var \Symfony\Component\Console\Input\InputInterface
	 */
	protected $input;

	/**
	 * The output interface implementation.
	 *
	 * @var \Symfony\Component\Console\Output\OutputInterface
	 */
	protected $output;

	/**
	 * Run the console command.
	 *
	 * @param  InputInterface  $input
	 * @param  OutputInterface  $output
	 * @return integer
	 */
	public function run(InputInterface $input, OutputInterface $output)
	{
		$this->input = $input;

		$this->output = $output;

		return parent::run($input, $output);
	}

	/**
	 * @return OutputInterface
	 */
	public function getOutput()
	{
		return $this->output;
	}

	/**
	 * writes a info level message
	 * @param $string
	 */
	public function info($string)
	{
		$this->output->writeln("<info>$string</info>");
	}
}