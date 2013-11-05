<?php

namespace DbViz\Ui;

use DbViz\DbVizTestCase;


class DotVisualizationCommandTest extends DbVizTestCase
{
	/**
	 * @test
	 * @expectedException \DbViz\Exception\UnknownDriverException
	 */
	public function testUnknownDriverThrowsException()
	{
		$this->runCommand('viz:dot', 'dsn', 'to');
	}

	/** @test */
	public function testNormalVisualization()
	{
		$dotFilePath = $this->createTemporaryFile();
		$dbFilePath = $this->createSqliteDbFromSqlFile(__DIR__ . '/../testdata/simple_sqlite_db.sql');
		$this->runCommand('viz:dot', "sqlite:$dbFilePath", $dotFilePath);
		$dotContents = file_get_contents($dotFilePath);

		$this->assertContains('"Author" -- "Comment"', $dotContents);
		$this->assertContains('"Author" -- "BlogPost"', $dotContents);
		$this->assertContains('"BlogPost" -- "Comment"', $dotContents);
		$this->assertRegexp('/Author.*size = 2/', $dotContents);
	}
}

