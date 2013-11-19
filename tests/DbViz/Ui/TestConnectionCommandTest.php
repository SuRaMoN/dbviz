<?php

namespace DbViz\Ui;

use DbViz\DbVizTestCase;


class TestConnectionCommandTest extends DbVizTestCase
{
	/**
	 * @test
	 */
	public function testUnknownDriverThrowsException()
	{
		$output = $this->runCommand('test:connection', 'invaliddsn');
		$this->assertContains('Connection to specified dsn failed', $output);
	}

	/**
	 * @test
	 */
	public function testSqliteTestConnection()
	{
		$output = $this->runCommand('test:connection', 'invaliddsn');
		$dbFilePath = $this->createSqliteDbFromSqlFile(__DIR__ . '/../testdata/simple_sqlite_db.sql');
		$output = $this->runCommand('test:connection', "sqlite:$dbFilePath");
		$this->assertContains('A connection could be establashed to the specified dsn', $output);
	}
}

