<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;
use PDO;


class SqliteTableSizeExtractor implements TableSizeExtractor
{
	public function getTableSizes(ConnectionCredentials $connectionCredentials)
	{
		$tableSizeMap = array();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$tablesStatement = $pdo->query('SELECT name FROM sqlite_master WHERE type = "table"');
		$tables = $tablesStatement->fetchAll(PDO::FETCH_COLUMN);

		foreach($tables as $table) {
			$size = $pdo->query("SELECT COUNT(*) FROM '$table';")->fetch(PDO::FETCH_COLUMN);
			$tableSizeMap[$table] = $size;
		}

		return $tableSizeMap;
	}
}
 
