<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDriver;
use DbViz\DbInfoExtractor\TableSizeExtractor\InterbaseTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\MssqlTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\MysqlTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\SqlbaseTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\SqliteTableSizeExtractor;
use DbViz\DbInfoExtractor\TableSizeExtractor\OracleTableSizeExtractor;
use Exception;


class TableSizeExtractorFactory
{
	public function __construct()
	{
	}
	
	public function getForDriver(DbDriver $driver)
	{
		switch($driver) {
			case DbDriver::SQLBASE():
				return new SqlbaseTableSizeExtractor();

			case DbDriver::INTERBASE():
				return new InterbaseTableSizeExtractor();

			case DbDriver::MSSQL():
				return new MssqlTableSizeExtractor();

			case DbDriver::MYSQL():
				return new MysqlTableSizeExtractor();

			case DbDriver::SQLITE():
				return new SqliteTableSizeExtractor();

			case DbDriver::ORACLE():
				return new OracleTableSizeExtractor();

			default:
				throw new Exception("Unknown driver: $driver");
		}
	}
}
 
