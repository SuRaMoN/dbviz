<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDriver;
use DbViz\DbInfoExtractor\TableSizeExtractor\MysqlTableSizeExtractor;
use DbViz\DbVizTestCase;


class TableSizeExtractorFactoryTest extends DbVizTestCase
{
	/** @test */
	public function testMysqlTableSizeExtractor()
	{
		$factory = new TableSizeExtractorFactory();
		$extractor = $factory->getForDriver(DbDriver::MYSQL());
		$this->assertTrue($extractor instanceof MysqlTableSizeExtractor);
	}
}

