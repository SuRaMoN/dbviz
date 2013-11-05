<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDrivers;
use DbViz\DbInfoExtractor\TableSizeExtractor\InterbaseTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\MssqlTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\MysqlTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\SqliteTableSizeExtractor;
use Exception;


class TableSizeExtractorFactory
{
	public function __construct()
	{
	}
	
	public function getForDriver($driver)
	{
		switch($driver) {
			case DbDrivers::INTERBASE:
				return new InterbaseTableSizeExtractor();

			case DbDrivers::MSSQL:
				return new MssqlTableSizeExtractor();

			case DbDrivers::MYSQL:
				return new MysqlTableSizeExtractor();

			case DbDrivers::SQLITE:
				return new SqliteTableSizeExtractor();

			default:
				throw new Exception("Unknown driver: $driver");
		}
	}
}
 
