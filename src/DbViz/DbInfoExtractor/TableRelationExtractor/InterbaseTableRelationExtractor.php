<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\Entity\ConnectionCredentials;
use DbViz\Entity\TableRelationCollection;
use PDO;


class InterbaseTableRelationExtractor implements TableRelationExtractor
{
	public function getTableRelations(ConnectionCredentials $connectionCredentials)
	{
		$relations = new TableRelationCollection();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$relationStatement = $pdo->query('
			SELECT DISTINCT
				rc.RDB$RELATION_NAME AS "source",
				d2.RDB$DEPENDED_ON_NAME AS "target"
			FROM RDB$RELATION_CONSTRAINTS rc
				LEFT JOIN RDB$REF_CONSTRAINTS refc ON rc.RDB$CONSTRAINT_NAME = refc.RDB$CONSTRAINT_NAME
				LEFT JOIN RDB$DEPENDENCIES d1 ON d1.RDB$DEPENDED_ON_NAME = rc.RDB$RELATION_NAME
				LEFT JOIN RDB$DEPENDENCIES d2 ON d1.RDB$DEPENDENT_NAME = d2.RDB$DEPENDENT_NAME
			WHERE rc.RDB$CONSTRAINT_TYPE = \'FOREIGN KEY\'
				AND d1.RDB$DEPENDED_ON_NAME <> d2.RDB$DEPENDED_ON_NAME
				AND d1.RDB$FIELD_NAME <> d2.RDB$FIELD_NAME
		');

		foreach($relationStatement->fetchAll(PDO::FETCH_OBJ) as $relation) {
			$relations->addRelation(trim($relation->source), trim($relation->target));
		}

		return $relations;
	}
}
 
