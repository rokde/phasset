<?php namespace Rokde\Phasset\Console;

use Rokde\Phasset\Commands\AboutCommand;
use Rokde\Phasset\Commands\UpdateCommand;

/**
 * Class Application
 *
 * The console application that handles the commands
 *
 * @package Rokde\Phasset\Console
 */
class Application extends \Symfony\Component\Console\Application
{
	/**
	 * current version number
	 */
	const VERSION = '1.0.0';

	/**
	 * the phasset logo
	 *
	 * @var string
	 */
	private static $logo = '       _                        _
      | |                      | |
 _ __ | |__   __ _ ___ ___  ___| |_
| \'_ \| \'_ \ / _` / __/ __|/ _ \ __|
| |_) | | | | (_| \__ \__ \  __/ |_
| .__/|_| |_|\__,_|___/___/\___|\__|
| |
|_|     ';

	/**
	 * starts console application with a qualified application name and the current version number
	 */
	public function __construct()
	{
		parent::__construct('Phasset', self::VERSION);

		$this->setDefaultCommand('update');
	}

	/**
	 * overrides the default help screen
	 *
	 * @return string
	 */
	public function getHelp()
	{
		return self::$logo . parent::getHelp();
	}


	/**
	 * Initializes all the commands available
	 */
	protected function getDefaultCommands()
	{
		$commands = parent::getDefaultCommands();

		$commands[] = new UpdateCommand();
		$commands[] = new AboutCommand();

		return $commands;
	}
}