<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\DbInfoExtractor\TableSizeExtractor\SqliteTableSizeExtractor;
use DbViz\DbVizTestCase;
use DbViz\Entity\ConnectionCredentials;


class SqliteTableSizeExtractorTest extends DbVizTestCase
{
	/** @test */
	public function testFunctionality()
	{
		$dbFile = $this->createSqliteDbFromSqlFile(__DIR__ . '/../../testdata/simple_sqlite_db.sql');
		$tableSizeExtractor = new SqliteTableSizeExtractor();
		$credentials = new ConnectionCredentials("sqlite:$dbFile");
		$sizeMap = $tableSizeExtractor->getTableSizes($credentials);

		$this->assertEquals(2, $sizeMap['Author']);
		$this->assertEquals(2, $sizeMap['BlogPost']);
		$this->assertEquals(4, $sizeMap['Comment']);
	}
}

