<?php

namespace DbViz\Ui;

use PDO;
use PDOException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class TestConnectionCommand extends EnvironmentAwareCommand
{
    protected function configure()
	{
		$this
			->setName('test:connection')
			->setDescription('Test database connection')
			->addOption('username', null, InputOption::VALUE_OPTIONAL, 'Database username')
			->addOption('password', null, InputOption::VALUE_OPTIONAL, 'Database password')
			->addArgument('dsn', InputArgument::REQUIRED, 'Database dsn to connect to');
		;
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {

		try {
			new PDO($input->getArgument('dsn'), $input->getOption('username'), $input->getOption('password'));
			$output->writeln('<info>A connection could be establashed to the specified dsn</info>');
		} catch(PDOException $e) {
			$output->writeln("<error>Connection to specified dsn failed: {$e->getMessage()}</error>");
		}
    }
}

