<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDriver;
use DbViz\DbInfoExtractor\TableRelationExtractor\InterbaseTableRelationExtractor;
use DbViz\DbInfoExtractor\TableRelationExtractor\MssqlTableRelationExtractor;
use DbViz\DbInfoExtractor\TableRelationExtractor\MysqlTableRelationExtractor;
use DbViz\DbInfoExtractor\TableRelationExtractor\SqliteTableRelationExtractor;
use Exception;


class TableRelationExtractorFactory
{
	public function __construct()
	{
	}
	
	public function getForDriver(DbDriver $driver)
	{
		switch($driver) {
			case DbDriver::INTERBASE():
				return new InterbaseTableRelationExtractor();

			case DbDriver::MSSQL():
				return new MssqlTableRelationExtractor();

			case DbDriver::MYSQL():
				return new MysqlTableRelationExtractor();

			case DbDriver::SQLITE():
				return new SqliteTableRelationExtractor();

			default:
				throw new Exception("Unknown driver: $driver");
		}
	}
}
 
