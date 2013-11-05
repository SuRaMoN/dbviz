<?php

namespace DbViz\Ui;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


abstract class EnvironmentAwareCommand extends Command
{
    protected function initialize(InputInterface $input, OutputInterface $output)
	{
		parent::initialize($input, $output);

		foreach($this->getDefinition()->getOptions() as $option) {
			$name = $option->getName();
			if(! $input->hasOption($name) && false !== getenv($name)) {
				$input->setOption($name, getenv($name));
			}
		}

		$argumentValues = array_values($input->getArguments());
		foreach($this->getDefinition()->getArguments() as $argument) {
			$name = $argument->getName();
			if(false !== getenv($name)) {
				$input->setArgument($name, getenv($name));
			} else {
				$input->setArgument($name, current($argumentValues));
				next($argumentValues);
			}
		}
	}
} 

