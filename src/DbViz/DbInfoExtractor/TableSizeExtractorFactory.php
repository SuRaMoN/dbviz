<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDriver;
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
	
	public function getForDriver(DbDriver $driver)
	{
		switch($driver) {
			case DbDriver::INTERBASE():
				return new InterbaseTableSizeExtractor();

			case DbDriver::MSSQL():
				return new MssqlTableSizeExtractor();

			case DbDriver::MYSQL():
				return new MysqlTableSizeExtractor();

			case DbDriver::SQLITE():
				return new SqliteTableSizeExtractor();

			default:
				throw new Exception("Unknown driver: $driver");
		}
	}
}
 
