<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\DbInfoExtractor\TableRelationExtractor\MysqlTableRelationExtractor;
use DbViz\DbVizTestCase;


class MysqlTableRelationExtractorTest extends DbVizTestCase
{
	/** @test */
	public function testFunctionality()
	{
		$this->skipIfNoMysql();

		$this->createMysqlDbFromSqlFile(__DIR__ . '/../../testdata/simple_mysql_db.sql');
		$relationsExtractor = new MysqlTableRelationExtractor();
		$relations = $relationsExtractor->getTableRelations($this->getMysqlCredentials())->getRelations();

		$this->assertContains(array('Comment', 'Author'), $relations);
		$this->assertContains(array('BlogPost', 'Author'), $relations);
		$this->assertContains(array('Comment', 'BlogPost'), $relations);
		$this->assertEquals(3, count($relations));
	}
}

