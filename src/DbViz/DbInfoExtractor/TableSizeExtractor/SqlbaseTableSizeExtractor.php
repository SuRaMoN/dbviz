<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;
use PDO;


class SqlbaseTableSizeExtractor
{
	public function getTableSizes(ConnectionCredentials $connectionCredentials)
	{
		$tableSizeMap = array();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$tablesStatement = $pdo->query('
			SELECT NAME, ROWCOUNT FROM SYSADM.SYSTABLES
		');
		$tables = $tablesStatement->fetchAll(PDO::FETCH_OBJ);

		foreach($tables as $table) {
			$tableSizeMap[$table->NAME] = $table->ROWCOUNT;
		}

		return $tableSizeMap;
	}
}
 
