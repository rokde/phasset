<?php namespace Rokde\Phasset\Observers;


use Symfony\Component\Console\Command\Command;

class SourceFileProcessingNotifier extends BaseObserver {

	public function observe()
	{
		/** @var Command $self */
		$self = $this->command;
		/** @var \Symfony\Component\Console\Helper\ProgressHelper $progress */
		$progress = $this->command->getHelper('progress');

		$this->events->addListener('phasset.source.processing', function ($sourceFileCount) use ($self, $progress) {
			$progress->start($self->getOutput(), $sourceFileCount);
		});
		$this->events->addListener('phasset.source.processing.file', function ($file, $step, $sourceFileCount) use ($progress) {
			$progress->advance();
		});
		$this->events->addListener('phasset.source.processed', function ($sourceFileCount) use ($self, $progress) {
			$progress->finish();
		});
	}
}