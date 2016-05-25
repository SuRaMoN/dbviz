<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;
use PDO;


class OracleTableSizeExtractor
{
	public function getTableSizes(ConnectionCredentials $connectionCredentials)
	{
		$tableSizeMap = array();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$tablesStatement = $pdo->query('
			SELECT
				owner || \'.\' || table_name AS tableName,
				num_rows AS rowCount
			FROM dba_tables
		');
		$tables = $tablesStatement->fetchAll(PDO::FETCH_OBJ);

		foreach($tables as $table) {
			$tableSizeMap[$table->TABLENAME] = $table->ROWCOUNT;
		}

		return $tableSizeMap;
	}
}
 
