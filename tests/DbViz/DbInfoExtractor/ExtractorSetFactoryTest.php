<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDriver;
use DbViz\DbInfoExtractor\TableRelationExtractor\MysqlTableRelationExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\MysqlTableSizeExtractor;
use DbViz\DbVizTestCase;


class ExtractorSetFactoryTest extends DbVizTestCase
{
	/** @test */
	public function testMysqlExtractorSetFunctionality()
	{
		$container = $this->createContainer();
		$extractors = $container['extractor_set.factory']->getForDriver(DbDriver::MYSQL());

		$this->assertTrue($extractors->getTableSizeExtractor() instanceof MysqlTableSizeExtractor);
		$this->assertTrue($extractors->getTableRelationExtractor() instanceof MysqlTableRelationExtractor);
	}
}

