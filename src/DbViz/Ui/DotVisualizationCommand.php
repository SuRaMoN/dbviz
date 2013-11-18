<?php

namespace DbViz\Ui;

use DbViz\DbInfoExtractor\ExtractorSetFactory;
use DbViz\DbUtil\DriverRecognizer;
use DbViz\DbVisualizator\DotDbVisualizator;
use DbViz\Entity\ConnectionCredentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class DotVisualizationCommand extends EnvironmentAwareCommand
{
	protected $dotDbVisualizator;
	protected $extractorSetFactory;
	protected $driverRecognizer;

	public function __construct(DriverRecognizer $driverRecognizer, ExtractorSetFactory $extractorSetFactory, DotDbVisualizator $dotDbVisualizator)
	{
		parent::__construct();
		$this->dotDbVisualizator = $dotDbVisualizator;
		$this->extractorSetFactory = $extractorSetFactory;
		$this->driverRecognizer = $driverRecognizer;
	}

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
		$connectionCredentials = new ConnectionCredentials($input->getArgument('dsn'), $input->getOption('username'), $input->getOption('password'));
		$driver = $this->driverRecognizer->getDriver($connectionCredentials);
		$extractors = $this->extractorSetFactory->getForDriver($driver);

		$tableSizeMap = $extractors->getTableSizeExtractor()->getTableSizes($connectionCredentials);
		$relations = $extractors->getTableRelationExtractor()->getTableRelations($connectionCredentials);

		$this->dotDbVisualizator->writeByFilePath($input->getArgument('to'), $relations, $tableSizeMap);
    }
}

