<?php

namespace DbViz\DbVisualizator;

use DbViz\DbVisualizator\DotDbVisualizator;
use DbViz\Entity\TableRelationCollection;
use PHPUnit_Framework_TestCase;


class DotDbVisualizatorTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function testFunctionality()
	{
		$dotVisualizator = new DotDbVisualizator();

		$relations = new TableRelationCollection();
		$relations->addRelation('jos', 'piet');
		$relations->addRelation('tutu', 'toto');

		$tableSizeMap = array(
			'jos' => 1,
			'marnau' => 2,
		);

		$dotString = $dotVisualizator->getString($relations, $tableSizeMap);

		$this->assertContains('graph', $dotString);
		$this->assertRegexp('/jos.*size.*1/', $dotString);
		$this->assertRegexp('/marnau.*size.*2/', $dotString);
		$this->assertRegexp('/jos.*--.*piet/', $dotString);
		$this->assertRegexp('/toto.*--.*tutu/', $dotString);
	}
}

