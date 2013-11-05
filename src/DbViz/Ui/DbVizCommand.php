<?php

namespace DbViz\Ui;

use DbViz\DbVizContainer;
use DbViz\Ui\EnvironmentAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


abstract class DbVizCommand extends EnvironmentAwareCommand
{
	protected $container;

	function __construct(DbVizContainer $container)
	{
		parent::__construct();
		$this->container = $container;
	}

	public function getContainer()
	{
		return $this->container;
	}
} 

