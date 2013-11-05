<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;
use PDO;


class MysqlTableSizeExtractor
{
	public function getTableSizes(ConnectionCredentials $connectionCredentials)
	{
		$tableSizeMap = array();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$tablesStatement = $pdo->query('
			SELECT
				table_name AS tableName,
				table_rows AS rowCount
			FROM INFORMATION_SCHEMA.TABLES
			WHERE
				TABLE_SCHEMA = DATABASE()
		');
		$tables = $tablesStatement->fetchAll(PDO::FETCH_OBJ);

		foreach($tables as $table) {
			$tableSizeMap[$table->tableName] = $table->rowCount;
		}

		return $tableSizeMap;
	}
}
 
