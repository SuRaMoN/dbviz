<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;
use DbViz\DbInfoExtractor\TableSizeExtractor\MysqlTableSizeExtractor;
use DbViz\DbVizTestCase;


class MysqlTableSizeExtractorTest extends DbVizTestCase
{
	/** @test */
	public function testFunctionality()
	{
		$this->skipIfNoMysql();

		$this->createMysqlDbFromSqlFile(__DIR__ . '/../../testdata/simple_mysql_db.sql');
		$tableSizeExtractor = new MysqlTableSizeExtractor();
		$sizeMap = $tableSizeExtractor->getTableSizes($this->getMysqlCredentials());

		$this->assertEquals(2, $sizeMap['Author']);
		$this->assertEquals(2, $sizeMap['BlogPost']);
		$this->assertEquals(4, $sizeMap['Comment']);
	}
}

