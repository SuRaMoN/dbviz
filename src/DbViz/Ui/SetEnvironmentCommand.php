<?php

namespace DbViz\Ui;

use DbViz\Entity\ConnectionCredentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class SetEnvironmentCommand extends EnvironmentAwareCommand
{
    protected function configure()
	{
		$this
			->setName('set')
			->setDescription('Set environment variable')
			->addArgument('name', InputArgument::REQUIRED, 'Name of variable to set')
			->addArgument('value', InputArgument::REQUIRED, 'Value of variable to set')
		;
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		putenv($input->getArgument('name') . '=' . $input->getArgument('value'));
    }
}

