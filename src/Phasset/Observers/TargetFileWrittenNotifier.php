<?php namespace Rokde\Phasset\Observers;


class TargetFileWrittenNotifier extends BaseObserver {

	/**
	 * observes the events
	 */
	public function observe()
	{
		$this->events->addListener('phasset.target.written', function ($file, $step, $targetFileCount) {
			$this->command->info($file . ' written');
		});
	}
}