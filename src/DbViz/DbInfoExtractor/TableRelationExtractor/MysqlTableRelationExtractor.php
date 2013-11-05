<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\Entity\ConnectionCredentials;
use DbViz\Entity\TableRelationCollection;
use PDO;


class MysqlTableRelationExtractor implements TableRelationExtractor
{
	public function getTableRelations(ConnectionCredentials $connectionCredentials)
	{
		$relations = new TableRelationCollection();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$relationStatement = $pdo->query('
			select
				TABLE_NAME as source,
				REFERENCED_TABLE_NAME as target
			from information_schema.KEY_COLUMN_USAGE
			where
				TABLE_SCHEMA = DATABASE()
				and TABLE_NAME != ""
				and REFERENCED_TABLE_NAME != ""
		');

		foreach($relationStatement->fetchAll(PDO::FETCH_OBJ) as $relation) {
			$relations->addRelation($relation->source, $relation->target);
		}

		return $relations;
	}
}
 
