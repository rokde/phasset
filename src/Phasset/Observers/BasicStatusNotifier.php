<?php namespace Rokde\Phasset\Observers;


use Rokde\Phasset\Events\TargetFileCountEvent;

class BasicStatusNotifier extends BaseObserver {

	public function observe()
	{
		$this->events->addListener('phasset.target.updating', function (TargetFileCountEvent $targetFileEvent) {
			$this->command->info('updating ' . $targetFileEvent->getCountTargetFiles() . ' asset files...');
		});
		$this->events->addListener('phasset.target.updated', function (TargetFileCountEvent $targetFileEvent) {
			$this->command->info($targetFileEvent->getCountTargetFiles() . ' asset files updated');
		});
	}
}