<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\Entity\ConnectionCredentials;
use DbViz\Entity\TableRelationCollection;
use PDO;


class MssqlTableRelationExtractor implements TableRelationExtractor
{
	public function getTableRelations(ConnectionCredentials $connectionCredentials)
	{
		$relations = new TableRelationCollection();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$relationStatement = $pdo->query('
			SELECT
				SourceTable.name AS source,
				TargetTable.name AS target
			FROM sys.foreign_key_columns AS Relation
				INNER JOIN sys.tables AS SourceTable ON Relation.parent_object_id = SourceTable.object_id
				INNER JOIN sys.tables AS TargetTable ON Relation.referenced_object_id = TargetTable.object_id
		');

		foreach($relationStatement->fetchAll(PDO::FETCH_OBJ) as $relation) {
			$relations->addRelation($relation->source, $relation->target);
		}

		return $relations;
	}
}
 
