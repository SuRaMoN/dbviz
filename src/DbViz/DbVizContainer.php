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

		$this['extractor_set.factory'] = $this->share(function($c) {
			return new \DbViz\DbInfoExtractor\ExtractorSetFactory(
				$c['table_relation_extractor.factory'],
				$c['table_size_extractor.factory']
			);
		});

		$this['dot_visualizer'] = $this->share(function($c) {
			return new \DbViz\DbVisualizator\DotDbVisualizator();
		});


		$this['command.dot_visualization'] = $this->share(function($c) {
			return new \DbViz\Ui\DotVisualizationCommand(
				$c['driver_recognizer'],
				$c['extractor_set.factory'],
				$c['dot_visualizer']
			);
		});

		$this['commands'] = $this->share(function($c) {
			$commands = new ArrayObject();
			$commands->append($c['command.dot_visualization']);
			$commands->append(new \DbViz\Ui\SetEnvironmentCommand());
			$commands->append(new \DbViz\Ui\EchoCommand());
			return $commands;
		});
	}

	public static function newInstance()
	{
	    return new self();
	}
	
}
 
