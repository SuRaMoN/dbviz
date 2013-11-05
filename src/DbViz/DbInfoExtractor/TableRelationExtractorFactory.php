<?php

namespace DbViz\DbInfoExtractor;

use DbViz\Constant\DbDrivers;
use DbViz\DbInfoExtractor\TableRelationExtractor\InterbaseTableRelationExtractor;
use DbViz\DbInfoExtractor\TableRelationExtractor\MssqlTableRelationExtractor;
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
			case DbDrivers::SQLITE:
				return new SqliteTableRelationExtractor();

			case DbDrivers::MSSQL:
				return new MssqlTableRelationExtractor();

			case DbDrivers::INTERBASE:
				return new InterbaseTableRelationExtractor();

			default:
				throw new Exception("Unknown driver: $driver");
		}
	}
}
 
