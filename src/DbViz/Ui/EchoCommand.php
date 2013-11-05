<?php

namespace DbViz\Ui;

use DbViz\Entity\ConnectionCredentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class EchoCommand extends DbVizCommand
{
    protected function configure()
	{
		$this
			->setName('echo')
			->setDescription('Print environment variable')
			->addArgument('name', InputArgument::REQUIRED, 'Name of variable echo')
		;
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		echo getenv($input->getArgument('name')), "\n";
    }
}

