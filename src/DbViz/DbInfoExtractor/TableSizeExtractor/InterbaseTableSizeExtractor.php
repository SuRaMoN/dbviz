<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;
use PDO;


class InterbaseTableSizeExtractor
{
	public function getTableSizes(ConnectionCredentials $connectionCredentials)
	{
		$tableSizeMap = array();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$tablesStatement = $pdo->query('SELECT DISTINCT RDB$RELATION_NAME FROM RDB$RELATION_FIELDS WHERE RDB$SYSTEM_FLAG = 0;');
		$tables = $tablesStatement->fetchAll(PDO::FETCH_COLUMN);

		foreach($tables as $table) {
			$table = trim($table);
			$size = $pdo->query("SELECT COUNT(*) FROM \"$table\";")->fetch(PDO::FETCH_COLUMN);
			$tableSizeMap[$table] = (int) $size;
		}

		return $tableSizeMap;
	}
}
 
