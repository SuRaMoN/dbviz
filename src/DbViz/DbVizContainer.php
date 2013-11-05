<?php

namespace DbViz;

use Pimple;
use ArrayObject;


class DbVizContainer extends Pimple
{
	public function __construct()
	{
		parent::__construct();

		$this['driver_recognizer'] = $this->share(function($c) {
			return new \DbViz\DbUtil\DriverRecognizer();
		});

		$this['table_size_extractor.factory'] = $this->share(function($c) {
			return new \DbViz\DbInfoExtractor\TableSizeExtractorFactory();
		});

		$this['table_relation_extractor.factory'] = $this->share(function($c) {
			return new \DbViz\DbInfoExtractor\TableRelationExtractorFactory();
		});

		$this['dot_visualizer'] = $this->share(function($c) {
			return new \DbViz\DbVisualizator\DotDbVisualizator();
		});

		$this['commands'] = $this->share(function($c) {
			$commands = new ArrayObject();
			$commands->append(new \DbViz\Ui\DotVisualizationCommand($c));
			$commands->append(new \DbViz\Ui\SetEnvironmentCommand($c));
			$commands->append(new \DbViz\Ui\EchoCommand($c));
			return $commands;
		});
	}
}
 
