<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDrivers;
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
	
	public function getForDriver($driver)
	{
		switch($driver) {
			case DbDrivers::INTERBASE:
				return new InterbaseTableRelationExtractor();

			case DbDrivers::MSSQL:
				return new MssqlTableRelationExtractor();

			case DbDrivers::MYSQL:
				return new MysqlTableRelationExtractor();

			case DbDrivers::SQLITE:
				return new SqliteTableRelationExtractor();

			default:
				throw new Exception("Unknown driver: $driver");
		}
	}
}
 
