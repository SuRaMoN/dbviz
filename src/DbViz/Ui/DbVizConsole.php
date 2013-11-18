<?php

namespace DbViz\Ui;

use Traversable;
use DbViz\DbVizContainer;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Shell;


class DbVizConsole extends Application
{
	public function __construct(Traversable $commands)
	{
		parent::__construct('DbViz', '@dbviz_package_version@');

		foreach($commands as $command) {
			$this->add($command);
		}
	}

	public function guiAwareRun(Input $input)
	{
		$application = $this;
		if(strlen($input) == 0) {
			$application = new Shell($application);
		}
		$application->run();
	}

	public static function newInstance(Traversable $commands)
	{
		return new self($commands);
	}
}
 
