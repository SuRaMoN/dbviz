<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\Entity\ConnectionCredentials;
use DbViz\Entity\TableRelationCollection;
use PDO;


class SqliteTableRelationExtractor implements TableRelationExtractor
{
	public function getTableRelations(ConnectionCredentials $connectionCredentials)
	{
		$relations = new TableRelationCollection();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$tablesStatement = $pdo->query('SELECT name FROM sqlite_master WHERE type = "table"');
		$tables = $tablesStatement->fetchAll(PDO::FETCH_COLUMN);

		foreach($tables as $table) {
			$relationStatement = $pdo->query("PRAGMA foreign_key_list('$table');");
			if($relationStatement->columnCount() == 0) {
				continue; // avoiding bug that makes php crash  whe n fetching from empty pragma query
			}
			foreach($relationStatement->fetchAll(PDO::FETCH_OBJ) as $relation) {
				$relations->addRelation($table, $relation->table);
			}
		}
		return $relations;
	}
}
 
