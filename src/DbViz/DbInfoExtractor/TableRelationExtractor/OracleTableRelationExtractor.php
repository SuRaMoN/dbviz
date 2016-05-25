<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\Entity\ConnectionCredentials;
use DbViz\Entity\TableRelationCollection;
use PDO;


class OracleTableRelationExtractor implements TableRelationExtractor
{
	public function getTableRelations(ConnectionCredentials $connectionCredentials)
	{
		$relations = new TableRelationCollection();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$relationStatement = $pdo->query('
            SELECT
                c.owner || \'.\' || a.table_name as SOURCE, c.r_owner || \'.\' || c_pk.table_name as TARGET
            FROM all_cons_columns a
            JOIN all_constraints c
                ON a.owner = c.owner
                AND a.constraint_name = c.constraint_name
            JOIN all_constraints c_pk
                ON c.r_owner = c_pk.owner
                AND c.r_constraint_name = c_pk.constraint_name
            WHERE
                c.constraint_type = \'R\'
		');

		foreach($relationStatement->fetchAll(PDO::FETCH_OBJ) as $relation) {
			$relations->addRelation($relation->SOURCE, $relation->TARGET);
		}

		return $relations;
	}
}
