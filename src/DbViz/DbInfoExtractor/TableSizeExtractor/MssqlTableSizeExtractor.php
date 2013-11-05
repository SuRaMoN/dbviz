<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;
use PDO;


class MssqlTableSizeExtractor
{
	public function getTableSizes(ConnectionCredentials $connectionCredentials)
	{
		$tableSizeMap = array();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$tablesStatement = $pdo->query('
			SELECT
				o.name AS tableName,
				ddps.row_count AS "rowCount"
			FROM sys.indexes AS i
				INNER JOIN sys.objects AS o ON i.OBJECT_ID = o.OBJECT_ID
				INNER JOIN sys.dm_db_partition_stats AS ddps ON i.OBJECT_ID = ddps.OBJECT_ID AND i.index_id = ddps.index_id 
			WHERE
				i.index_id < 2
				AND o.is_ms_shipped = 0
			ORDER BY o.NAME
		');
		$tables = $tablesStatement->fetchAll(PDO::FETCH_OBJ);

		foreach($tables as $table) {
			$tableSizeMap[$table->tableName] = $table->rowCount;
		}

		return $tableSizeMap;
	}
}
 
