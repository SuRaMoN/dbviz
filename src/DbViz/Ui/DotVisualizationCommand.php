<?php

namespace DbViz\Ui;

use DbViz\Entity\ConnectionCredentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class DotVisualizationCommand extends DbVizCommand
{
    protected function configure()
	{
		$this
			->setName('viz:dot')
			->setDescription('Visualize to dot format')
			->addOption('username', null, InputOption::VALUE_OPTIONAL, 'Database username')
			->addOption('password', null, InputOption::VALUE_OPTIONAL, 'Database password')
			->addArgument('dsn', InputArgument::REQUIRED, 'Database dsn to connect to')
			->addArgument('to', InputArgument::REQUIRED, 'File path of dot file')
		;
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$container = $this->getContainer();

		$connectionCredentials = new ConnectionCredentials($input->getArgument('dsn'), $input->getOption('username'), $input->getOption('password'));
		$driver = $container['driver_recognizer']->getDriverName($connectionCredentials);
		$tableSizeExtractor = $container['table_size_extractor.factory']->getForDriver($driver);
		$tableRelationExtractor = $container['table_relation_extractor.factory']->getForDriver($driver);

		$tableSizeMap = $tableSizeExtractor->getTableSizes($connectionCredentials);
		$relations = $tableRelationExtractor->getTableRelations($connectionCredentials);

		$container['dot_visualizer']->writeByFilePath($input->getArgument('to'), $relations, $tableSizeMap);
    }
}

