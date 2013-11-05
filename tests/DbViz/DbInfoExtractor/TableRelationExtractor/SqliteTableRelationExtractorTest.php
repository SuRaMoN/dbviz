<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\DbInfoExtractor\TableRelationExtractor\SqliteTableRelationExtractor;
use DbViz\DbVizTestCase;
use DbViz\Entity\ConnectionCredentials;


class SqliteTableRelationExtractorTest extends DbVizTestCase
{
	/** @test */
	public function testFunctionality()
	{
		$dbFile = $this->createSqliteDbFromSqlFile(__DIR__ . '/../../testdata/simple_sqlite_db.sql');
		$relationsExtractor = new SqliteTableRelationExtractor();
		$credentials = new ConnectionCredentials("sqlite:$dbFile");
		$relations = $relationsExtractor->getTableRelations($credentials)->getRelations();

		$this->assertContains(array('Comment', 'Author'), $relations);
		$this->assertContains(array('BlogPost', 'Author'), $relations);
		$this->assertContains(array('Comment', 'BlogPost'), $relations);
		$this->assertEquals(3, count($relations));
	}
}

