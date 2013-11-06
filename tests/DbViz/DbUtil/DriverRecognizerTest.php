<?php

namespace DbViz\DbUtil;

use DbViz\Entity\ConnectionCredentials;
use DbViz\Constant\DbDrivers;
use DbViz\DbVizTestCase;
use DbViz\DbUtil\DriverRecognizer;


class DriverRecognizerTest extends DbVizTestCase
{
	/**
	 * @test
	 * @expectedException \DbViz\Exception\UnknownDriverException
	 */
	public function testUnknownDriverThrowException()
	{
		$this->assertDriverIs(0, 'bliablabloe');
	}

	/** @test */
	public function testMysqlRecognition()
	{
		$this->assertDriverIs(DbDrivers::MYSQL, 'mysql:bliablabloe');
	}

	/** @test */
	public function testSqliteRecognition()
	{
		$this->assertDriverIs(DbDrivers::SQLITE, 'sqlite:bliablabloe');
	}

	/** @test */
	public function testUnixSqliteOdbcRecognition()
	{
		$this->assertDriverIs(DbDrivers::SQLITE, 'odbc:DRIVER=Sqlite3;Database=bliblabloe');
	}

	/** @test */
	public function testWindowsSqliteOdbcRecognition()
	{
		$this->assertDriverIs(DbDrivers::SQLITE, 'odbc:DSN=SQLite3 Datasource;Database=full-path-to-db');
	}

	protected function assertDriverIs($expectedDriver, $dsn)
	{
		$driverRecognizer = new DriverRecognizer();
		$credentials = new ConnectionCredentials($dsn);
		$this->assertEquals($expectedDriver, $driverRecognizer->getDriverName($credentials));
	}
}

